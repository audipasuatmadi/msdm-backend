<?php

namespace lib\investor\interfaces;

interface IInvestorRepository {
    public function store($name, $stocks);
    public function getAll();
    public function update($id, $name, $stocks);
    public function delete($id);
    public function getStakeholders();
}