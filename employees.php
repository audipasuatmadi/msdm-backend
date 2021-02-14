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

function handleCreateEmployee(IEmployeeService $employeeService, $requestBody) {
    $name = $requestBody['name'];
    $roleId = $requestBody['roleId'];
    $workHours = $requestBody['workHours'];
    $salary = $requestBody['salary'];
    
    $processReturn = $employeeService->store($name, $roleId, $workHours, $salary);

    if ($processReturn['status'] == 201) {
        http_response_code(201);
        return json_encode(["otherMessage" => "karyawan berhasil ditambahkan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah karyawan"]);
    }
}

function handleUpdateEmployee(IEmployeeService $employeeService, $requestBody) {
    $id = $requestBody['id'];
    $name = $requestBody['name'];
    $roleId = $requestBody['roleId'];
    $workHours = $requestBody['workHours'];
    $salary = $requestBody['salary'];

    $processReturn = $employeeService->update($id, $name, $roleId, $workHours, $salary);

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil diperbaharui"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam memperbaharui karyawan"]);
    }

}

function handleDeleteEmployee(IEmployeeService $employeeService, $requestBody) {
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

function handleGetAllEmployees(IEmployeeService $employeeService) {
    $processReturn = $employeeService->getAll();
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "semua data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "belum terdapat data karyawan"]);
    }
    else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleSearchByName(IEmployeeService $employeeService, $requestBody) {
    $name = $requestBody['name'];
    $processReturn = $employeeService->searchByName($name);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    }
    else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleSearchByWorkHoursRange(IEmployeeService $employeeService, $requestBody) {
    $from = $requestBody['from'];
    $until = $requestBody['until'];
    $processReturn = $employeeService->searchByWorkHoursRange($from, $until);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    }
    else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleGetCountByJob(IEmployeeService $employeeService, $requestBody) {
    $args = 0;

    if (isset($requestBody['min'])) {
        $args = $requestBody['min'];
    }
    $processReturn = $employeeService->getCountByJob($args);
    
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    }
    else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}

function handleAssignEmployeeToDepartment(IEmployeeService $employeeService, IDepartmentService $departmentService, $requestBody) {
    $employeeId = $requestBody['employeeId'];
    $departmentId = $requestBody['departmentId'];
    
    $processReturn = $employeeService->assignToDepartment($employeeId, $departmentService, $departmentId);
    
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil ditambahkan ke department"]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode($processReturn);
    }
    else {
        http_response_code(500);
        return json_encode($processReturn);
    }
}

function handleUnassignEmployeeFromDepartment(IEmployeeService $employeeService, $requestBody) {
    $employeeId = $requestBody['employeeId'];
    $departmentId = $requestBody['departmentId'];
    
    $processReturn = $employeeService->unassignFromDepartment($employeeId, $departmentId);
    
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "karyawan berhasil dikeluarkan ke department"]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode($processReturn);
    }
    else {
        http_response_code(500);
        return json_encode($processReturn);
    }
}

function handleGetByRoles(IEmployeeService $employeeService, $requestBody) {
    $roleIdArray = $requestBody['roleIds'];

    $processReturn = $employeeService->findByRoles($roleIdArray);
    
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "data karyawan berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "data karyawan tidak ditemukan"]);
    }
    else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus karyawan"]);
    }
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestBody['code'])) {
        return 0;
    }
    if ($requestBody['code'] == 1) {
        $response = handleCreateEmployee($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 3) {
        $response = handleUpdateEmployee($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 4) {
        $response = handleDeleteEmployee($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 5) {
        $response = handleGetAllEmployees($employeeService);
        echo $response;
    }
    if ($requestBody['code'] == 6) {
        $response = handleSearchByName($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 7) {
        $response = handleSearchByWorkHoursRange($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 8) {
        $response = handleGetCountByJob($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 9) {
        $response = handleAssignEmployeeToDepartment($employeeService, $departmentService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 10) {
        $response = handleUnassignEmployeeFromDepartment($employeeService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 11) {
        $response = handleGetByRoles($employeeService, $requestBody);
        echo $response;
    }
}