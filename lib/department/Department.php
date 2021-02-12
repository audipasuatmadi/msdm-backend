<?php

namespace lib\department;

use lib\department\interfaces\IDepartment;

class Department implements IDepartment
{
    private int $id;
    private string $name;
    private string $description;

    public function __construct($name, $description, $id = 0)
    {
        $this->name = $name;
        $this->description = $description;
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
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
}
