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
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT *, gaji - (gaji * 0.02) AS gaji_bersih FROM karyawan WHERE id=?");
        $stmt->bind_param("i", $id);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $employee = $results->fetch_assoc();
                $conn->close();
                return ["status" => 200, 'payload' => $employee];
            } else {
                $conn->close();
                return ['status' => 404];
            }
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }

    public function findByRoles($roleArray)
    {
        $conn = $this->database->connect();
        $roleArray = implode(",", $roleArray);
        $stmt = $conn->prepare("SELECT *, gaji - (gaji * 0.02) AS gaji_bersih FROM karyawan JOIN jabatan WHERE jabatan.id=karyawan.jabatan_id AND jabatan.id IN ($roleArray) ORDER BY jabatan.id DESC");
        
        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $karyawan = $results->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ['status' => 200, 'payload' => $karyawan];
            } else {
                $conn->close();
                return ['status' => 404];
            }
        } else {
            $conn->close();
            return ['status' => 500];
        }
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
        
        if ($executeResult == 1) {
            $conn->close();
            return ["status" => 200];
        } else {
            $conn->close();
            return ["status" => 500];
        }
    }
    public function getAll()
    {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT *, gaji - (gaji * 0.02) AS gaji_bersih FROM karyawan");
        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $allData = $results->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ["status" => 200, "payload" => $allData];
            } else {
                $conn->close();
                return ["status" => 404];
            }
        } else {
            $conn->close();
            return ["status" => 500];
        }
    }
    public function delete(IEmployee $employee)
    {
        $id = $employee->getId();
        $conn = $this->database->connect();

        $stmt = $conn->prepare("DELETE FROM karyawan WHERE id=?");
        $stmt->bind_param("i", $id);

        $executeResult = $stmt->execute();
        if ($executeResult == 1) {
            $conn->close();
            return ['status' => 200];
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }

    public function searchByName(string $name) {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT *, gaji - (gaji * 0.02) AS gaji_bersih FROM karyawan WHERE nama LIKE \"$name%\" OR nama LIKE \"% $name%\"");
        $executeResult = $stmt->execute();

        if ($executeResult == 1) {
            $nameResults = $stmt->get_result();
            if ($nameResults->num_rows > 0) {
                $employees = $nameResults->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ['status' => 200, 'payload' => $employees];
            } else {
                $conn->close();
                return ['status' => 404];
            }
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }

    public function searchByWorkHoursRange(float $from, float $until)
    {
        $conn = $this->database->connect();

        $from = (double) $from;
        $until = (double) $until;
        
        $stmt = $conn->prepare("SELECT *, gaji - (gaji * 0.02) AS gaji_bersih FROM karyawan WHERE karyawan.jam_kerja BETWEEN ? AND ? ORDER BY jam_kerja ASC");
        $stmt->bind_param("dd", $from, $until);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $queryResult = $stmt->get_result();
            if ($queryResult->num_rows > 0) {
                $employees = $queryResult->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ['status' => 200, 'payload' => $employees];
            } else {
                $conn->close();
                return ['status' => 404];
            }
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }

    public function getCountByJob(int $min = 0)
    {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT COUNT(karyawan.id) as jml_karyawan, jabatan.nama as nama_jabatan FROM karyawan JOIN jabatan WHERE jabatan.id=karyawan.jabatan_id GROUP BY jabatan.nama HAVING jml_karyawan > ?");
        $stmt->bind_param("i", $min);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $queryResult = $stmt->get_result();
            if ($queryResult->num_rows > 0) {
                $countData = $queryResult->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ['status' => 200, 'payload' => $countData];
            } else {
                $conn->close();
                return ['status' => 404];
            }
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }

}
