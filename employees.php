<?php

use database\Database;
use lib\departmentemployee\DepartmentEmployeeRepository;
use lib\department\DepartmentRepository;
use lib\department\DepartmentService;
use lib\department\interfaces\IDepartmentService;
use lib\employee\EmployeeRepository;
use lib\employee\EmployeeService;
use lib\employee\interfaces\IEmployeeService;

require_once('./autoloader.php');


$database = new Database();
$employeeRepository = new EmployeeRepository($database);
$departmentEmployeeRepo = new DepartmentEmployeeRepository($database);
$employeeService = new EmployeeService($employeeRepository, $departmentEmployeeRepo);
$departmentService = new DepartmentService(new DepartmentRepository($database));

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");



function handleDeleteEmployee(IEmployeeService $employeeService, $requestBody)
{
    $id = $requestBody['id'];

    $processReturn = $employeeService->delete($id);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil dihapus"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleGetAllEmployees(IEmployeeService $employeeService)
{
    $processReturn = $employeeService->getAll();
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "semua data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "belum terdapat data karyawan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleSearchByName(IEmployeeService $employeeService, $requestBody)
{
    $name = $requestBody['name'];
    $processReturn = $employeeService->searchByName($name);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleSearchByWorkHoursRange(IEmployeeService $employeeService, $requestBody)
{
    $from = $requestBody['from'];
    $until = $requestBody['until'];
    $processReturn = $employeeService->searchByWorkHoursRange($from, $until);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleGetCountByJob(IEmployeeService $employeeService, $requestBody)
{
    $min = 0;
    $max = 1000;

    if (isset($requestBody['min'])) {
        $min = $requestBody['min'];  
    }
    if (isset($requestBody['max'])) {
        $max = $requestBody['max'];
    }
    $processReturn = $employeeService->getCountByJob($min, $max);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleAssignEmployeeToDepartment(IEmployeeService $employeeService, IDepartmentService $departmentService, $requestBody)
{
    $employeeId = $requestBody['employeeId'];
    $departmentId = $requestBody['departmentId'];

    $processReturn = $employeeService->assignToDepartment($employeeId, $departmentService, $departmentId);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil ditambahkan ke department"]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode($processReturn);
    } else {
        http_response_code(500);
        return json_encode($processReturn);
    }
}


function handleCreateEmployee(IEmployeeService $employeeService, $requestBody, IDepartmentService $departmentService)
{
    $name = $requestBody['name'];
    $roleId = $requestBody['roleId'];
    $workHours = $requestBody['workHours'];
    $salary = $requestBody['salary'];

    
    $processReturn = $employeeService->store($name, $roleId, $workHours, $salary);
    
    if ($processReturn['status'] == 201) {
        if (isset($requestBody['departmentId'])) {
            $id = $processReturn['payload'];
            $prp = [
                "employeeId" => intval($id),
                "departmentId" => $requestBody['departmentId']
            ];
            $depId = $requestBody['departmentId'];
            return json_encode($employeeService->assignToDepartment($id, $departmentService, $depId));
        }
        http_response_code(201);
        return json_encode(["otherMessage" => "karyawan berhasil ditambahkan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah karyawan"]);
    }
}

function handleUpdateEmployee(IEmployeeService $employeeService, $requestBody, IDepartmentService $departmentService)
{
    $id = $requestBody['id'];
    $name = $requestBody['name'];
    $roleId = $requestBody['roleId'];
    $workHours = $requestBody['workHours'];
    $salary = $requestBody['salary'];

    $processReturn = $employeeService->update($id, $name, $roleId, $workHours, $salary);

    if ($processReturn['status'] == 200) {
        if (isset($requestBody['departmentId'])) {
            $depId = $requestBody['departmentId'];
            return json_encode($employeeService->assignToDepartment($id, $departmentService, $depId));
        }
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil diperbaharui"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam memperbaharui karyawan"]);
    }
}

function handleUnassignEmployeeFromDepartment(IEmployeeService $employeeService, $requestBody)
{
    $employeeId = $requestBody['employeeId'];
    $departmentId = $requestBody['departmentId'];

    $processReturn = $employeeService->unassignFromDepartment($employeeId, $departmentId);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil dikeluarkan ke department"]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode($processReturn);
    } else {
        http_response_code(500);
        return json_encode($processReturn);
    }
}

function handleGetByRoles(IEmployeeService $employeeService, $requestBody)
{
    $roleIdArray = $requestBody['roleIds'];

    $processReturn = $employeeService->findByRoles($roleIdArray);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleFindById(IEmployeeService $employeeService, $requestBody)
{
    $id = $requestBody['id'];

    $processReturn = $employeeService->findById($id);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // $requestBody = json_decode(file_get_contents('php://input'), true);
    $response = json_encode(["otherMessage" => "API route tidak ditemukan"]);

    $requestBody = $_GET;


    if (!isset($requestBody['code'])) {
        return 0;
    }

    switch ($requestBody['code']) {
        case 1:
            $response = handleFindById($employeeService, $requestBody);
            break;
        case 2:
            $response = handleGetAllEmployees($employeeService);
            break;
        case 3:
            $response = handleSearchByName($employeeService, $requestBody);
            break;
        case 4:
            $response = handleSearchByWorkHoursRange($employeeService, $requestBody);
            break;
        case 5:
            $response = handleGetCountByJob($employeeService, $requestBody);
            break;
        case 6:
            $response = handleGetByRoles($employeeService, $requestBody);
            break;
        default:
            http_response_code(404);
            break;
    }
    echo $response;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);
    $response = json_encode(["otherMessage" => "API route tidak ditemukan"]);

    
    if (!isset($requestBody['code'])) {
        return 0;
    }
    
    switch ($requestBody['code']) {
        case 1:
            $response = handleCreateEmployee($employeeService, $requestBody, $departmentService);
            break;
        case 2:
            $response = handleUpdateEmployee($employeeService, $requestBody, $departmentService);
            break;
        case 3:
            $response = handleDeleteEmployee($employeeService, $requestBody);
            break;
        case 4:
            /*
            "employeeId",
            "departmentId"
            */
            $response = handleAssignEmployeeToDepartment($employeeService, $departmentService, $requestBody);
            break;
        case 5:
            $response = handleUnassignEmployeeFromDepartment($employeeService, $requestBody);
            break;
        default:
            http_response_code(404);
            break;
    }

    echo $response;
}
