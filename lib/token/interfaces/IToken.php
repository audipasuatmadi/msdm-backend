<?php

namespace lib\token\interfaces;



interface IToken {
    /**
     * Fungsi ini akan me return token yang dimiliki admin
     * Digunakan untuk mengambil token
     *
     * @return string
     */
    public function getToken();

    /**
     * Digunakan untuk mengganti nilai token
     *
     * @param string $token
     * @return void
     */
    public function setToken(string $token);

    /**
     *
     * @return int
     */
    public function getAdminId();
}