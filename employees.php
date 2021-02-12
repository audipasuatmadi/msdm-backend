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
    var_dump($processReturn);

    if ($processReturn['status'] == 201) {
        http_response_code(201);
        return json_encode(["otherMessage" => "karyawan berhasil ditambahkan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah karyawan"]);
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
}