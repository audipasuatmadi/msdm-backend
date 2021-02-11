<?php

namespace lib\utils\interfaces;

interface BaseRepository {
    public function getById(int $id);
}