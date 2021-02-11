<?php

// use database\IDatabase;
namespace interfaces;

interface IDatabase
{
    public function __construct($configuration = null);
    /**
     * Undocumented function
     *
     * @return \mysqli
     */
    public function connect();
}

namespace database;

use interfaces\IDatabase;

class Database implements IDatabase
{
    private $configuration;

    /**
     * Fungsi ini digunakan untuk menginstansiasikan + memberi konfigurasi khusus terhadap basis data.
     *
     * @param object|null $configuration
     * @return null;
     */
    public function __construct($configuration = null)
    {
        if ($configuration == null) {
            $configuration = (object) [
                "serverName" => "localhost",
                "name" => "root",
                "password" => "",
                "database" => "msdm_db"
            ];
        }

        $this->configuration = $configuration;
    }

    /**
     * Fungsi ini digunakan untuk menginstansiasikan + memberi konfigurasi khusus terhadap basis data.
     *
     * @return int|object;
     */
    public function connect()
    {
        $connection = new \mysqli($this->configuration->serverName, $this->configuration->name, $this->configuration->password, $this->configuration->database);
        if ($connection->connect_errno) {
            return 500;
        } else {
            return $connection;
        }
    }
}