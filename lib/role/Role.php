<?php

namespace lib\role;

use lib\role\interfaces\IRole;

class Role implements IRole
{
    private int $id;
    private string $name;

    public function __construct($name, $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
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
}
