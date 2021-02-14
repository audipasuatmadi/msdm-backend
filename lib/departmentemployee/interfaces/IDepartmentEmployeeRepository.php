<?php

namespace lib\departmentemployee\interfaces;

use interfaces\IDatabase;
use lib\department\interfaces\IDepartment;
use lib\employee\interfaces\IEmployee;

interface IDepartmentEmployeeRepository {
    public function __construct(IDatabase $database);
    public function assignToDepartment($employeeId, $departmentId);
    public function unassignFromDepartment(IEmployee $employee, IDepartment $department);
}