<?php

namespace lib\token;

use lib\token\interfaces\IToken as InterfacesIToken;

class Token implements InterfacesIToken
{

    private string $token;
    private int $adminId;

    public function __construct($token, $adminId)
    {
        $this->token = $token;
        $this->adminId = $adminId;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getAdminId()
    {
        return $this->adminId;
    }
}
