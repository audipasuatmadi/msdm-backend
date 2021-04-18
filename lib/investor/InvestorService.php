<?php

namespace lib\investor;

use lib\investor\interfaces\IInvestorRepository;
use lib\investor\interfaces\IInvestorService;

class InvestorService implements IInvestorService 
{
    private IInvestorRepository $repository;

    public function __construct (IInvestorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($name, $stocks) {
        return $this->repository->store($name, $stocks);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function update($id, $name, $stocks)
    {
        return $this->repository->update($id, $name, $stocks);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}