<?php
namespace lib\token\interfaces;

interface ITokenRepository {
    public function store(IToken $modelObject);
    /**
     *
     * @return IToken
     */
    public function getById(int $id);
    public function delete(IToken $modelObject);
    public function update(IToken $modelObject);
    public function getByAdminId(int $id);
}