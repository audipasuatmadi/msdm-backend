<?php

namespace lib\admin;

use lib\utils\BaseCredentials;

class Admin implements BaseCredentials
{

    private string $username;
    private string $password;
    /**
     * Constructor untuk class Admin
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}
