<?php

namespace lib\admin;

use lib\admin\interfaces\IAdminRepository;
use lib\admin\interfaces\IAdminService;
use lib\utils\interfaces\BaseCredentialsRepository;
use lib\utils\interfaces\BaseRepository;

class AdminService implements IAdminService
{
    private IAdminRepository $repository;

    public function __construct(IAdminRepository $repository)
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
        $repositoryReturn = $this->repository->getByUsername($username);
        if ($repositoryReturn == 404) {
            return 404;
        }  

        //TODO: create and return a token
        if (password_verify($password, $repositoryReturn['password'])) {
            return 1;
        } else {
            return 403;
        }
        
    }
    public function getAll()
    {
    }

    //TODO: implement validate token

}
