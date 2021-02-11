<?php 
namespace lib\utils\interfaces;

interface ResourcesRepository {
    public function store($modelObject);
    public function getById(int $id);
    public function delete($modelObject);
    public function update($modelObject);
}