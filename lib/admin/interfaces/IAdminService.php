<?php

namespace lib\admin\interfaces;

//TODO: implement validate
interface IAdminService {
    public function create(string $username, string $password);
    public function login(string $username, string $password);
    public function getAll();
    public function validate(string $token);
}