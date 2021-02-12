<?php

require_once('./autoloader.php');

use database\Database;
use lib\admin\AdminRepository;
use lib\admin\AdminService;
use lib\admin\interfaces\IAdminService;
use lib\token\TokenRepository as TokenTokenRepository;

$database = new Database();

$tokenRepository = new TokenTokenRepository($database);
$adminService = new AdminService(new AdminRepository($database), $tokenRepository);


function handleCreateAdmin(AdminService $adminService, $requestBody) {
    if (!(isset($requestBody['username']) && isset($requestBody['password']))) {
        http_response_code(403);
        echo json_encode(["username" => "username harus diisi", "password" => "password harus diisi"]);
    } else {
        
        $username = $requestBody['username'];
        $password = $requestBody['password'];

        $return = $adminService->create($username, $password);
        if ($return['status'] == 201) {
            http_response_code(201);
            echo json_encode(["otherMessage" => "admin berhasil ditambahkan", "payload" => $return['payload']]);
        } else if ($return['status'] == 403) {
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
        if ($return['status'] == 200) {
            http_response_code(200);
            echo json_encode(["otherMessage" => "login berhasil", "payload" => $return['payload']]);
        } else if ($return['status'] == 404) {
            http_response_code(404);
            echo json_encode(["username" => "username tidak ditemukan"]);
        } else if ($return['status'] == 403) {
            http_response_code(403);
            echo json_encode(["password" => "password tidak valid"]);
        } else {
            http_response_code(500);
            echo json_encode(["otherMessage" => "terjadi kesalahan dalam server"]);
        }
    }
}

function handleValidation(IAdminService $adminService, $requestBody) {
    $token = (string) $requestBody['token'];
    $val = $adminService->validate($token);
    return $val;
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
    if ($requestBody['code'] == 3) {
        $response = handleValidation($adminService, $requestBody);
        // var_dump($response);
        echo $response['payload'];
    }
}
