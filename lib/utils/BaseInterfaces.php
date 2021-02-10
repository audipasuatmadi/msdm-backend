<?php

namespace lib\utils;

interface BaseCredentials {
    public function getUsername();
    public function setUsername(string $username);
    public function getPassword();
    public function setPassword(string $password);
}