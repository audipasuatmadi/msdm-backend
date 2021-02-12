<?php

namespace lib\employee;

use lib\employee\interfaces\IEmployee;

class Employee implements IEmployee
{
    private int $id;
    private string $name;
    private int $roleId;
    private float $workHours;
    private int $salary;

    public function __construct($name, $roleId, $workHours, $salary, $id = 0)
    {
        $this->name = $name;
        $this->roleId = $roleId;
        $this->workHours = $workHours;
        $this->salary = $salary;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getRoleId()
    {
        return $this->roleId;
    }
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }
    public function getWorkHours()
    {
        return $this->workHours;
    }
    public function setWorkHours($hours)
    {
        $this->workHours = $hours;
    }
    public function getSalary()
    {
        return $this->salary;
    }
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
}