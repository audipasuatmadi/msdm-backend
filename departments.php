<?php

use database\Database;
use lib\department\DepartmentRepository;
use lib\department\DepartmentService;
use lib\department\interfaces\IDepartmentService;

require_once('./autoloader.php');

$database = new Database();
$departmentRepository = new DepartmentRepository($database);
$departmentService = new DepartmentService($departmentRepository);

function handleCreateDepartment(IDepartmentService $departmentService, $requestBody) {
    $name = $requestBody['name'];
    $description = $requestBody['description'];
    
    $processReturn = $departmentService->store($name, $description);
    if ($processReturn['status'] == 201) {
        http_response_code(201);
        echo json_encode(["otherMessage" => "department berhasil ditambahkan"]);
    }
}

function handleUpdateDepartment(IDepartmentService $departmentService, $requestBody) {
    $id = $requestBody['id'];
    $name = $requestBody['name'];
    $description = $requestBody['description'];
    
    $processReturn = $departmentService->update($id, $name, $description);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        echo json_encode(["otherMessage" => "department berhasil diperbaharui"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestBody['code'])) {
        return 0;
    }
    if ($requestBody['code'] == 1) {
        $response = handleCreateDepartment($departmentService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 2) {
        $response = handleUpdateDepartment($departmentService, $requestBody);
        echo $response;
    } 
}