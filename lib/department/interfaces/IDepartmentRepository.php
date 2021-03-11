<?php

namespace lib\department\interfaces;

interface IDepartmentRepository
{
    public function store(IDepartment $department);
    public function update(IDepartment $department);
    /**
     * @return IDepartment
     */
    public function findById(int $id);
    public function delete(IDepartment $department);
    public function getAll();
}