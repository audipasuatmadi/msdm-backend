<?php

use database\Database;
use lib\admin\Admin;
use lib\admin\AdminRepository;

require_once "./autoloader.php";



$repo = new AdminRepository(new Database());
$admin = new Admin("awdea", "Adw");
$execyut = $repo->getByid(1);

echo $execyut;