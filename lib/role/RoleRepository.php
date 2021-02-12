<?php

namespace lib\role;

use interfaces\IDatabase;
use lib\role\interfaces\IRole;
use lib\role\interfaces\IRoleRepository;

class RoleRepository implements IRoleRepository {
    private IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store(IRole $role) {
        $conn = $this->database->connect();

        $name = $role->getName();

        $stmt = $conn->prepare("INSERT INTO jabatan (nama) VALUES (?)");
        $stmt->bind_param("s", $name);

        $executeResult = $stmt->execute();
        $conn->close();
        if ($executeResult == 1) {
            return ['status' => 201, 'payload' => $conn->insert_id];
        } else {
            return ['status' => 500, 'payload' => $executeResult];
        }

    }
    public function findById(int $id) {
        $conn = $this->database->connect();
        
        $stmt = $conn->prepare("SELECT * FROM jabatan WHERE id=?");
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $executeResult = $stmt->get_result();
        $conn->close();
        if ($executeResult->num_rows == 1) {
            $roleData = $executeResult->fetch_assoc();
            $role = new Role($roleData['nama'], $roleData['id']);
            return ["status" => 200, "payload" => $role];
        } else {
            return ["status" => 404];
        }
    }
    public function update(IRole $role) {
        $conn = $this->database->connect();

        $id = $role->getId();
        $name = $role->getName();

        $stmt = $conn->prepare("UPDATE jabatan SET nama=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        $executeResult = $stmt->execute();
        $conn->close();
        if ($executeResult == 1) {
            return ['status' => 200, 'payload' => $conn->insert_id];
        } else {
            return ['status' => 500, 'payload' => $executeResult];
        }
    }
    public function getAll() {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT * FROM jabatan");
        $executeResult = $stmt->execute();
    
        $result = $stmt->get_result();
        $conn->close();
        if ($executeResult == 1) {
            if ($result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                return ["status" => 200, "payload" => $data];
            } else {
                return ["status" => 404];
            }
        } else {
            return ["status" => 500];
        }

    }
    public function delete(IRole $role) {
        $id = $role->getId();
        $conn = $this->database->connect();

        $stmt = $conn->prepare("DELETE FROM jabatan WHERE id=?");
        $stmt->bind_param("i", $id);

        $executeResult = $stmt->execute();
        $conn->close();
        if ($executeResult == 1) {
            return ['status' => 200];
        } else {
            return ['status' => 500];
        }
    }
}