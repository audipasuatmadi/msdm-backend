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

        $name = ucfirst(strtolower($name));

        $stmt = $conn->prepare("INSERT INTO jabtan (nama) VALUES (?)");
        $stmt->bind_param("s", $name);

        $executeResult = $stmt->execute();
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
        if ($executeResult->num_rows == 1) {
            return ["status" => 200, "payload" => $executeResult->fetch_assoc()];
        } else {
            return ["status" => 404];
        }
    }
    public function update(IRole $role) {

    }
    public function getAll() {

    }
    public function delete(IRole $role) {

    }
}