<?php

namespace token;

use token\interfaces\IToken;

class Token implements IToken
{

    private string $token;

    public function __construct($token)
    {
        $this->token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }
}
