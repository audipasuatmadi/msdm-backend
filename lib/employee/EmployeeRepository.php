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
        $conn->close();
        if ($executeResult == 1) {
            return ["status" => 201, "payload" => $conn->insert_id];
        } else {
            return ["status" => 500];
        }

    }
    public function findById(int $id)
    {
    }
    public function update(IEmployee $employee)
    {
    }
    public function getAll()
    {
    }
    public function delete(IEmployee $employee)
    {
    }
}
