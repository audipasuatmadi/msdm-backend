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
        return $role;
    }
    public function update($id, $name) {
        $role = new Role($name, $id);
        $repositoryReturn = $this->repository->update($role);
        return $repositoryReturn;
    }
    public function delete($id) {
        $rolePayload = $this->repository->findById($id);
        if ($rolePayload['status'] == 200) {
            $role = $rolePayload['payload'];
            $delReturn = $this->repository->delete($role);
            return $delReturn;
        } else {
            return $rolePayload;
        }
    }
    public function getAll() {
        $allData = $this->repository->getAll();
        return $allData;
    }
}