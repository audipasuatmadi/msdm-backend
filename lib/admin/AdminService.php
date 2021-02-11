<?php

namespace lib\admin;

use lib\admin\interfaces\IAdminRepository;
use lib\admin\interfaces\IAdminService;
use lib\token\interfaces\ITokenRepository;
use lib\token\Token;

class AdminService implements IAdminService
{
    private IAdminRepository $repository;
    private ITokenRepository $tokenRepository;

    public function __construct(IAdminRepository $repository, ITokenRepository $tokenRepository)
    {
        $this->repository = $repository;
        $this->tokenRepository = $tokenRepository;
    }

    public function create(string $username, string $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $admin = new Admin($username, $hashedPassword);
        $returnType = $this->repository->store($admin);

        if ($returnType['status'] == 201) {
            $token = new Token(strval($returnType['payload']), $returnType['payload']);
            $this->tokenRepository->store($token);
            $adminId = $token->getAdminId();
            $returnType['payload'] = $adminId;
        }

        return $returnType;
    }
    public function login(string $username, string $password)
    {
        $repositoryReturn = $this->repository->getByUsername($username);
        if ($repositoryReturn == 404) {
            return ['status' => 404];
        }  

        //TODO: create and return a token
        if (password_verify($password, $repositoryReturn['password'])) {
            return ['status' => 200, 'payload' => $repositoryReturn['id']];
        } else {
            return ['status'=> 403];
        }
        
    }
    public function getAll()
    {
    }

    //TODO: implement validate token

}
