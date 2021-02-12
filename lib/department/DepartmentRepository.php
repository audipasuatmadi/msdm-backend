<?php

namespace lib\department;

use interfaces\IDatabase;
use lib\department\interfaces\IDepartment;
use lib\department\interfaces\IDepartmentRepository;

class DepartmentRepository implements IDepartmentRepository
{
    private IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store(IDepartment $department)
    {
        $conn = $this->database->connect();

        $name = $department->getName();
        $description = $department->getDescription();

        $stmt = $conn->prepare("INSERT INTO departemen (nama, deskripsi) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        $executeResult = $stmt->execute();
        if ($executeResult == 1) {
            return ['status' => 201, 'payload' => $conn->insert_id];
        } else {
            return ['status' => 500, 'payload' => $executeResult];
        }
    }
    public function update(IDepartment $department)
    {
        $conn = $this->database->connect();
        $name = $department->getName();
        $description = $department->getDescription();
        $id = $department->getId();

        $stmt = $conn->prepare("UPDATE departemen SET nama=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $description, $id);
        $executeResult = $stmt->execute();
        if ($executeResult == 1) {
            return ['status' => 200, 'payload' => $conn->insert_id];
        } else {
            return ['status' => 500, 'payload' => $executeResult];
        }
    }
    public function findById(int $id)
    {
    }
    public function delete(IDepartment $department)
    {
    }
}
