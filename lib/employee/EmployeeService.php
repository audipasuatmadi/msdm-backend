<?php

namespace lib\employee;

use lib\employee\interfaces\IEmployeeRepository;
use lib\employee\interfaces\IEmployeeService;

class EmployeeService implements IEmployeeService
{
    private IEmployeeRepository $repository;

    public function __construct(IEmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($name, $roleId, $workHours, $salary)
    {
        $employee = new Employee($name, $roleId, $workHours, $salary);
        $repoReturn = $this->repository->store($employee);
        return $repoReturn;
    }
    public function findById(int $id)
    {
        
    }
    public function update($id, $name, $roleId, $workHours, $salary)
    {
        $employee = new Employee($name, $roleId, $workHours, $salary, $id);
        $repoReturn = $this->repository->update($employee);
        return $repoReturn;
    }
    public function getAll()
    {
        $employees = $this->repository->getAll();
        return $employees;
    }
    public function delete($id)
    {
        $employee = new Employee('a', 1, 1, 1, $id);
        $repoReturn = $this->repository->delete($employee);
        return $repoReturn;
    }
    public function searchByName(string $name)
    {
        $employees = $this->repository->searchByName($name);
        return $employees;
    }
    public function searchByWorkHoursRange(float $from, float $until)
    {
        $employees = $this->repository->searchByWorkHoursRange($from, $until);
        return $employees;
    }
}
