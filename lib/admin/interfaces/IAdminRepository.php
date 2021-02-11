<?php

namespace lib\admin\interfaces;

use lib\utils\interfaces\BaseCredentialsRepository;

interface IAdminRepository extends BaseCredentialsRepository {
    public function getByUsername(string $username);
}