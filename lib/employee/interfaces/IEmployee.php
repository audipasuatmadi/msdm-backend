<?php

namespace lib\employee\interfaces;

interface IEmployee {
    public function getId();
    public function setId($id);
    public function getName();
    public function setName($name);
    public function getRoleId();
    public function setRoleId($roleId);
    public function getWorkHours();
    public function setWorkHours($hours);
    public function getSalary();
    public function setSalary($salary);
}