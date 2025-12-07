<?php

namespace App\Domain\Customer\Repositories;

use App\Domain\Customer\Entities\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
}
