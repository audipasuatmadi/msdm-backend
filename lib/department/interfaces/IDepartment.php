<?php

namespace lib\department\interfaces;

interface IDepartment {
    public function getName();
    public function setName($name);
    public function getDescription();
    public function setDescription($description);
    public function getId();
    public function setId($id);
}