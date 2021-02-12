<?php

namespace lib\role;

use lib\role\interfaces\IRoleRepository;
use lib\role\interfaces\IRoleService;

class RoleService implements IRoleService {
    private IRoleRepository $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($name) {
        $role = new Role($name);
        $repositoryReturn = $this->repository->store($role);
        return $repositoryReturn;
    }
    public function findById($id) {
        $role = $this->repository->findById($id);
    }
    public function update($id, $name) {
        
    }
    public function delete($id) {

    }
    public function getAll() {

    }
}