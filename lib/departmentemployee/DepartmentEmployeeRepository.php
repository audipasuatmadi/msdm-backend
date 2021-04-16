<?php

namespace lib\departmentemployee;

use lib\departmentemployee\interfaces\IDepartmentEmployeeRepository;
use interfaces\IDatabase;
use lib\department\interfaces\IDepartment;
use lib\employee\interfaces\IEmployee;

class DepartmentEmployeeRepository implements IDepartmentEmployeeRepository {
    private IDatabase $database;
    public function __construct(IDatabase $database) {
        $this->database = $database;
    }
    public function assignToDepartment($employeeId, $departmentId) {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("SELECT COUNT(1) FROM departemen_karyawan WHERE karyawan_id=?");
        $stmt->bind_param('i', $employeeId);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return ['status' => 403, 'payload' => 'karyawan sudah berada di suatu departemen'];
            }
        }

        $stmt = $conn->prepare("INSERT INTO departemen_karyawan (karyawan_id, departemen_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $employeeId, $departmentId);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $payload = $stmt->insert_id;
            $conn->close();
            return ['status' => 201, 'payload' => $payload];
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }
    public function unassignFromDepartment($employeeId, $departmentId) {
        $conn = $this->database->connect();

        $stmt = $conn->prepare("DELETE FROM departemen_karyawan WHERE karyawan_id=? AND departemen_id=?");
        $stmt->bind_param("ii", $employeeId, $departmentId);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $conn->close();
            return ['status' => 200];
        } else {
            $conn->close();
            return ['status' => 500];
        }
    }
}