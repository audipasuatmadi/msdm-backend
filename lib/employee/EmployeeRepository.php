<?php

namespace lib\employee;

use interfaces\IDatabase;
use lib\employee\interfaces\IEmployee;
use lib\employee\interfaces\IEmployeeRepository;

class EmployeeRepository implements IEmployeeRepository
{
    private IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store(IEmployee $employee)
    {
        $conn = $this->database->connect();
        
        $nama = $employee->getName();
        $workHours = $employee->getWorkHours();
        $workHours = (double) $workHours;
        $salary = $employee->getSalary();
        $roleId = $employee->getRoleId();

        $stmt = $conn->prepare("INSERT INTO karyawan (nama, jam_kerja, gaji, jabatan_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $nama, $workHours, $salary, $roleId);

        $executeResult = $stmt->execute();
        $status = $conn->insert_id;
        $conn->close();
        if ($executeResult == 1) {
            return ["status" => 201, "payload" => $status];
        } else {
            return ["status" => 500];
        }

    }
    public function findById(int $id)
    {
    }
    public function update(IEmployee $employee)
    {
        $id = $employee->getId();
        $name = $employee->getName();
        $roleId = $employee->getRoleId();
        $workHours = $employee->getWorkHours();
        $salary = $employee->getSalary();

        $conn = $this->database->connect();
        $stmt = $conn->prepare("UPDATE karyawan SET nama=?, jam_kerja=?, gaji=?, jabatan_id=? WHERE id=?");
        $stmt->bind_param("sdiii", $name, $workHours, $salary, $roleId, $id);

        $executeResult = $stmt->execute();
        $conn->close();

        if ($executeResult == 1) {
            return ["status" => 200];
        } else {
            return ["status" => 500];
        }

    }
    public function getAll()
    {
    }
    public function delete(IEmployee $employee)
    {
        $id = $employee->getId();
        $conn = $this->database->connect();

        $stmt = $conn->prepare("DELETE FROM karyawan WHERE id=?");
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
