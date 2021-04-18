<?php

use database\Database;
use lib\investor\interfaces\IInvestorService;
use lib\investor\InvestorRepository;
use lib\investor\InvestorService;

require_once('./autoloader.php');

$database = new Database();
$investorRepo = new InvestorRepository($database);
$investorService = new InvestorService($investorRepo);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

function handleGetAllInvestors(IInvestorService $service) {
    $processReturn = $service->getAll();
    $status = $processReturn['status'];
    http_response_code($status);
    return json_encode($processReturn['payload']);
}

function handleCreateInvestor(IInvestorService $service, $requestBody) {
    $processReturn = $service->store($requestBody['name'], $requestBody['stocks']);
    $status = $processReturn['status'];
    http_response_code($status);
    return 'succcess';
}

function handleUpdateInvestor(IInvestorService $service, $requestBody) {
    $processReturn = $service->update($requestBody['id'], $requestBody['name'], $requestBody['stocks']);
    $status = $processReturn['status'];
    http_response_code($status);
    return 'succcess';
}

function handleDeleteInvestor(IInvestorService $service, $requestBody) {
    $processReturn = $service->delete($requestBody['id']);
    $status = $processReturn['status'];
    http_response_code($status);
    return 'succcess';
}

function handleGetStakeholders(IInvestorService $service) {
    $processReturn = $service->getStakeholders();
    $status = $processReturn['status'];
    http_response_code($status);
    return json_encode($processReturn['payload']);
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $requestBody = json_decode(file_get_contents('php://input'), true);
    $response = 'unknown';
    if (!isset($requestBody['code'])) {
        http_response_code(400);
        echo 'Kode harus ada';
        return 0;
    }

    switch($requestBody['code']) {
        case 1:
            $response = handleCreateInvestor($investorService, $requestBody);
            break;
        case 2:
            $response = handleUpdateInvestor($investorService, $requestBody);
            break;
        case 3:
            $response = handleDeleteInvestor($investorService, $requestBody);
            break;
        default:
            http_response_code(404);
    }
    echo $response;
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $requestBody = $_GET;
    $response = 'unknown';
    if (!isset($requestBody['code'])) {
        http_response_code(400);
        echo 'Kode harus ada';
        return 0;
    }

    switch($requestBody['code']) {
        case 1:
            $response = handleGetAllInvestors($investorService);
            break;
        case 2:
            $response = handleGetStakeholders($investorService);
            break;
        default:
            http_response_code(404);
    }

    echo $response;
}