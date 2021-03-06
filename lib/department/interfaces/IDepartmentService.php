<?php

namespace lib\department\interfaces;

interface IDepartmentService {
    public function store($name, $description);
    public function findById($id);
    public function update($id, $name, $description, IDepartment $department = null);
    public function delete($id);
    public function getAll();
}