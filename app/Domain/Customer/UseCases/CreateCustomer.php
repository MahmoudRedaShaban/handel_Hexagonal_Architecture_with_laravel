<?php

namespace App\Domain\Customer\UseCases;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepository;

class CreateCustomer
{
    public function __construct(private CustomerRepository $repo)
    {
    }

    public function execute(string $name, string $email)
    {
        $customer = new Customer($name,$email);
        $this->repo->save();  // Handel in Adapter Using Port
    }
}
