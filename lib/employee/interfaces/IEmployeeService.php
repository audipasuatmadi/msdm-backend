<?php

namespace lib\employee\interfaces;

interface IEmployeeService {
    public function store($name, $roleId, $workHours, $salary);
    public function findById(int $id);
    public function update($id, $name, $roleId, $workHours, $salary);
    public function getAll();
    public function delete($id);
}