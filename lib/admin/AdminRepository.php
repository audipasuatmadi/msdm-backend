<?php

namespace lib\admin;
// require '../utils/BaseInterfaces.php';

use interfaces\IDatabase;
use lib\utils\interfaces\BaseCredentialsRepository;


class AdminRepository implements BaseCredentialsRepository
{
    private IDatabase $database;
    
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store($adminData)
    {
        $conn = $this->database->connect();
        if (gettype($conn) == "integer") {
            echo "an error occured".$conn;
            return $conn;
        } else {
            $username = $adminData->getUsername();
            $usernameExists = $this->getByUsername($username);
            
            if ($usernameExists == 404) {
                $stmt = $conn->prepare("INSERT INTO admin_data (username, password) VALUES (?, ?)");
                $username = $adminData->getUsername();
                $password = $adminData->getPassword();

                $stmt->bind_param("ss", $username, $password);
                return $stmt->execute();
            } else {
                return 403;
            }
            
        }
    }

    public function getByUsername(string $username)
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare("SELECT * FROM admin_data WHERE username=?");
        $stmt->bind_param("s", $username);

        $return = $stmt->execute();
        $return = $stmt->get_result();
        if ($return->num_rows == 1) {
            return $return->fetch_assoc();
        } else {
            return 404;
        }
    }

    public function getByid(int $id)
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare("SELECT * FROM admin_data WHERE id=?");
        $stmt->bind_param("s", $id);

        $return = $stmt->execute();
        $return = $stmt->get_result();
        if ($return->num_rows == 1) {
            return $return->fetch_assoc();
        } else {
            return 404;
        }
    }

    public function delete($data)
    {
    }
    public function update($data)
    {
        
    }
}
