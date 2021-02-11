<?php

require_once('./autoloader.php');

use database\Database;
use lib\admin\AdminRepository;
use lib\admin\AdminService;

$database = new Database();

$adminService = new AdminService(new AdminRepository($database));


function handleCreateAdmin(AdminService $adminService, $requestBody) {
    if (!(isset($requestBody['username']) && isset($requestBody['password']))) {
        http_response_code(403);
        echo json_encode(["username" => "username harus diisi", "password" => "password harus diisi"]);
    } else {
        
        $username = $requestBody['username'];
        $password = $requestBody['password'];

        $return = $adminService->create($username, $password);
        if ($return == 1) {
            http_response_code(201);
            echo json_encode(["otherMessage" => "admin berhasil ditambahkan"]);
        } else if ($return == 403) {
            http_response_code(403);
            echo json_encode(["username" => "username telah digunakan"]);
        } else {
            http_response_code(500);
            echo json_encode(["otherMessage" => "terjadi kesalahan dalam server"]);
        }
    }
}

function handleLoginAdmin(AdminService $adminService, $requestBody) {
    if (!(isset($requestBody['username']) && isset($requestBody['password']))) {
        http_response_code(403);
        echo json_encode(["username" => "username harus diisi", "password" => "password harus diisi"]);
    } else {
        
        $username = $requestBody['username'];
        $password = $requestBody['password'];

        $return = $adminService->login($username, $password);
        if ($return == 1) {
            http_response_code(201);
            echo json_encode(["otherMessage" => "login berhasil"]);
        } else if ($return == 404) {
            http_response_code(404);
            echo json_encode(["username" => "username tidak ditemukan"]);
        } else if ($return == 403) {
            http_response_code(403);
            echo json_encode(["password" => "password tidak valid"]);
        } else {
            http_response_code(500);
            echo json_encode(["otherMessage" => "terjadi kesalahan dalam server"]);
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestBody['code'])) {
        return 0;
    }
    if ($requestBody['code'] == 1) {
        $response = handleCreateAdmin($adminService, $requestBody);
        echo $response;
    } 
    if ($requestBody['code'] == 2) {
        $response = handleLoginAdmin($adminService, $requestBody);
        echo $response;
    }
}