<?php

namespace lib\admin;

use lib\admin\interfaces\IAdminService;
use lib\utils\interfaces\BaseCredentialsRepository;
use lib\utils\interfaces\BaseRepository;

class AdminService implements IAdminService
{
    private BaseCredentialsRepository $repository;

    public function __construct(BaseCredentialsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $username, string $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $admin = new Admin($username, $hashedPassword);
        $returnType = $this->repository->store($admin);
        
        return $returnType;
    }
    public function login(string $username, string $password)
    {
    }
    public function getAll()
    {
    }
}
