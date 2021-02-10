<?php

namespace lib\utils\interfaces;

interface BaseCredentialsRepository extends BaseRepository
{
    public function store(BaseCredentials $data);
    public function delete(BaseCredentials $data);
    public function update(BaseCredentials $data);
}
