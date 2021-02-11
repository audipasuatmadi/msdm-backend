<?php

namespace token\interfaces;

use lib\utils\interfaces\BaseCredentials;



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
     * Fungsi ini akan me return Credentials Utama Pengguna
     * Digunakan untuk mencari admin jika diketahui token
     *
     * @return BaseCredentials
     */
    public function getUser();
}