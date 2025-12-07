<?php

namespace App\Domain\Customer\UseCases;

use App\Domain\Customer\Repositories\CustomerRepository;

class DeleteCustomer
{
    public function __construct(private CustomerRepository $repo)
    {
    }
    public function execut(int $id)
    {
        return $this->repo->delete($id);
    }
}
