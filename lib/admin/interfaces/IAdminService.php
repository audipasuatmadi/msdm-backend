<?php

namespace lib\admin\interfaces;

interface IAdminService {
    public function create(string $username, string $password);
    public function login(string $username, string $password);
    public function getAll();
}