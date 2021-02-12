<?php

use database\Database;
use lib\role\interfaces\IRoleService;
use lib\role\RoleRepository;
use lib\role\RoleService;

require_once('./autoloader.php');

$database = new Database();
$roleRepository = new RoleRepository($database);
$roleService = new RoleService($roleRepository);

function handleCreateRole(IRoleService $roleService, $requestBody) {
    $name = $requestBody['name'];
    $processReturn = $roleService->store($name);
    
    if ($processReturn['status'] == 201) {
        http_response_code(201);
        return json_encode(["otherMessage" => "jabatan berhasil ditambahkan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah jabatan"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestBody['code'])) {
        return 0;
    }
    if ($requestBody['code'] == 1) {
        $response = handleCreateRole($roleService, $requestBody);
        echo $response;
    }
    // if ($requestBody['code'] == 2) {
    //     $response = handleUpdateDepartment($departmentService, $requestBody);
    //     echo $response;
    // } 
}