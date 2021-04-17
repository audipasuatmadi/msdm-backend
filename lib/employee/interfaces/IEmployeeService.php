<?php

namespace lib\employee\interfaces;

use lib\department\interfaces\IDepartmentService;


interface IEmployeeService {
    public function store($name, $roleId, $workHours, $salary);
    public function findById(int $id);
    public function findByRoles($roleIdArrays);
    public function update($id, $name, $roleId, $workHours, $salary);
    public function updateWithObject(IEmployee $employee);
    public function getAll();
    public function delete($id);
    public function searchByName(string $name);
    public function searchByWorkHoursRange(float $from, float $until);
    public function getCountByJob(int $min = 0);
    public function assignToDepartment($id, IDepartmentService $departmentService, $departmentId);
    public function unassignFromDepartment($id, $departmentId);
}