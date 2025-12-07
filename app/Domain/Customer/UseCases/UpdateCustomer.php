<?php

namespace App\Domain\Customer\UseCases;

use App\Domain\Customer\Repositories\CustomerRepository;

class UpdateCustomer
{
    public function __construct(private CustomerRepository $repo)
    {
    }
    public function execut(int $id, string $name, string $email)
    {
        return $this->repo->update($id, $name, $email);
    }
}
