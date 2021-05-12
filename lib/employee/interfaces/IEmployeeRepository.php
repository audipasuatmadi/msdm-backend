<?php

namespace lib\employee\interfaces;

interface IEmployeeRepository {
    public function store(IEmployee $employee);
    public function findById(int $id);
    public function update(IEmployee $employee);
    public function getAll();
    public function delete(IEmployee $employee);
    public function searchByName(string $name);
    public function searchByWorkHoursRange(float $from, float $until);
    public function getCountByJob(int $min = 0, int $max = 1000);
    public function findByRoles($roleArray);
}