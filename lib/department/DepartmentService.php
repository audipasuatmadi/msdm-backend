<?php

namespace lib\department;

use lib\department\interfaces\IDepartment;
use lib\department\interfaces\IDepartmentRepository;
use lib\department\interfaces\IDepartmentService;

class DepartmentService implements IDepartmentService
{
    private IDepartmentRepository $repository;

    public function __construct(IDepartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($name, $description)
    {
        $department = new Department($name, $description);
        $repositoryResult = $this->repository->store($department);
        return $repositoryResult;
    }
    public function findById($id)
    {
        $department = $this->repository->findById($id);
        return $department;
    }
    public function update($id, $name, $description, IDepartment $department = null)
    {
        if ($department == null) {
            $department = new Department($name, $description, $id);
            $repositoryResult = $this->repository->update($department);
            return $repositoryResult;
        } else {
            $repositoryResult = $this->repository->update($department);
            return $repositoryResult;
        }
    }
    public function delete($id)
    {
    }
    public function getAll()
    {
    }
}
