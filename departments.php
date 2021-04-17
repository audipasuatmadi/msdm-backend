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
        return json_encode(["otherMessage" => "department berhasil ditambahkan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah department"]);
    }
}

function handleUpdateDepartment(IDepartmentService $departmentService, $requestBody) {
    $id = $requestBody['id'];
    $name = $requestBody['name'];
    $description = $requestBody['description'];
    
    $processReturn = $departmentService->update($id, $name, $description);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "department berhasil diperbaharui"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam memperbaharui department"]);
    }
}

function handleGetAllDepartments(IDepartmentService $departmentService)
{
    $processReturn = $departmentService->getAll();
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "semua data departmen berhasil diambil", "payload" => $processReturn['payload']]);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "belum terdapat data departemen"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam mengambil departmen"]);
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $requestBody = $_GET;

    if (!isset($requestBody['code'])) {
        return 0;
    }
    if ($requestBody['code'] == 1) {
        $response = handleGetAllDepartments($departmentService, $requestBody);
        echo $response;
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