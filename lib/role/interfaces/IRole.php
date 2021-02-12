<?php

namespace lib\role\interfaces;

interface IRole {
    public function getId();
    public function setId($id);
    public function setName($name);
    public function getName();
}