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

function handleGetAllRoles(IRoleService $roleService) {
    $processReturn = $roleService->getAll();

    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode($processReturn);
    } elseif ($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "daftar jabatan kosong"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menambah jabatan"]);
    }
}

function handleUpdateRole(IRoleService $roleService, $requestBody) {
    $id = $requestBody['id'];
    $name = $requestBody['name'];
    
    $processReturn = $roleService->update($id, $name);
    if ($processReturn['status'] == 200) {
        http_response_code(201);
        return json_encode(["otherMessage" => "jabatan berhasil diperbaharui"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam memperbaharui jabatan"]);
    }
}

function handleDeleteRole(IRoleService $roleService, $requestBody) {
    $id = $requestBody['id'];

    $processReturn = $roleService->delete($id);
    if ($processReturn['status'] == 200) {
        http_response_code(200);
        return json_encode(["otherMessage" => "jabatan berhasil dihapus"]);
    } elseif($processReturn['status'] == 404) {
        http_response_code(404);
        return json_encode(["otherMessage" => "jabatan yang ingin dihapus tidak ditemukan"]);
    } else {
        http_response_code(500);
        return json_encode(["otherMessage" => "terjadi kesalahan backend dalam menghapus jabatan"]);
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
    if ($requestBody['code'] == 3) {
        $response = handleUpdateRole($roleService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 4) {
        $response = handleDeleteRole($roleService, $requestBody);
        echo $response;
    }
    if ($requestBody['code'] == 5) {
        $response = handleGetAllRoles($roleService);
        echo $response;
    } 
}