<?php

namespace lib\employee;

use lib\departmentemployee\DepartmentEmployeeRepository;
use lib\departmentemployee\interfaces\IDepartmentEmployeeRepository;
use lib\employee\interfaces\IEmployee;
use lib\employee\interfaces\IEmployeeRepository;
use lib\employee\interfaces\IEmployeeService;

class EmployeeService implements IEmployeeService
{
    private IEmployeeRepository $repository;
    private IDepartmentEmployeeRepository $departmentEmployeeRepo;

    public function __construct(IEmployeeRepository $repository, IDepartmentEmployeeRepository $departmentEmployeeRepo)
    {
        $this->repository = $repository;
        $this->departmentEmployeeRepo = $departmentEmployeeRepo;
    }

    public function store($name, $roleId, $workHours, $salary)
    {
        $employee = new Employee($name, $roleId, $workHours, $salary);
        $repoReturn = $this->repository->store($employee);
        return $repoReturn;
    }
    public function findById(int $id)
    {
        $employee = $this->repository->findById($id);
        return $employee;
    }
    public function update($id, $name, $roleId, $workHours, $salary, IEmployee $employee = null)
    {
        if ($employee == null) {
            $employee = new Employee($name, $roleId, $workHours, $salary, $id);
            $repoReturn = $this->repository->update($employee);
            return $repoReturn;
        } else {
            $repoReturn = $this->repository->update($employee);
            return $repoReturn;
        }
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
    public function getCountByJob(int $min = 0)
    {
        $countData = $this->repository->getCountByJob($min);
        return $countData;
    }

    public function updateWithObject(IEmployee $employee)
    {
        $repoReturn = $this->repository->update($employee);
        return $repoReturn;
    }

    public function assignToDepartment($id, $departmentService, $departmentId)
    {
        $employee = $this->findById($id);
        if ($employee['status'] == 200) {
            $employee = $employee['payload'];
            
            $department = $departmentService->findById($departmentId);
            if ($department['status'] == 200) {
                $department = $department['payload'];
                $result = $this->departmentEmployeeRepo->assignToDepartment($employee['id'], $department['id']);
                return $result;
            } else {
                return ['status' => '404', 'otherMessage' => 'departemen tidak ditemukan'];
            }

        } else {
            return ['status' => '404', 'otherMessage' => 'karyawan tidak ditemukan'];
        }
    }

}
