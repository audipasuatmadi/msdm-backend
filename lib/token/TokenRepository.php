<?php

namespace lib\token;

use interfaces\IDatabase;
use lib\token\interfaces\ITokenRepository as InterfacesITokenRepository;

class TokenRepository implements InterfacesITokenRepository
{

    private IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store($modelObject)
    {
        $token = $modelObject->getToken();
        $adminId = $modelObject->getAdminId();

        $conn = $this->database->connect();
        $stmt = $conn->prepare("INSERT INTO token_data (token, admin_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $token, $adminId);
        return $stmt->execute();
        
    }
    public function getById(int $id)
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare("SELECT * FROM token_data WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $return = $stmt->get_result();
        if ($return->num_rows == 1) {
            return $return->fetch_assoc();
        } else {
            return 404;
        }
    }

    public function getByAdminId(int $adminId)
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare("SELECT * FROM token_data WHERE admin_id=?");
        $stmt->bind_param("s", $adminId);
        $stmt->execute();

        $return = $stmt->get_result();
        if ($return->num_rows == 1) {
            return $return->fetch_assoc();
        } else {
            return 404;
        }
    }

    public function delete($modelObject)
    {
    }
    public function update($modelObject)
    {
    }
}
