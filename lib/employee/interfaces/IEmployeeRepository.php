<?php

namespace lib\employee\interfaces;

interface IEmployeeRepository {
    public function store(IEmployee $employee);
    public function findById(int $id);
    public function update(IEmployee $employee);
    public function getAll();
    public function delete(IEmployee $employee);
}