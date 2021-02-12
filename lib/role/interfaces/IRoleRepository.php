<?php

namespace lib\role\interfaces;

interface IRoleRepository {
    public function store(IRole $role);
    public function findById(int $int);
    public function update(IRole $role);
    public function getAll();
    public function delete(IRole $role);
}