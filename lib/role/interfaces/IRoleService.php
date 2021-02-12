<?php

namespace lib\role\interfaces;

interface IRoleService {
    public function store($name);
    public function findById($id);
    public function update($id, $name);
    public function delete($id);
    public function getAll();
}