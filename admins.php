<?php

require_once('./autoloader.php');

use database\Database;
use lib\admin\AdminRepository;
use lib\admin\AdminService;

$database = new Database();

$adminService = new AdminService(new AdminRepository($database));


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);
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