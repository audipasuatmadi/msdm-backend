<?php

use database\Database;
use lib\employee\EmployeeRepository;
use lib\employee\EmployeeService;
use lib\employee\interfaces\IEmployeeService;

require_once('./autoloader.php');

$database = new Database();
$employeeRepository = new EmployeeRepository($database);
$employeeService = new EmployeeService($employeeRepository);
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
}