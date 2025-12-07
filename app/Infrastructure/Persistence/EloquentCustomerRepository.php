<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepository;
use App\Models\Customer as ModelsCustomer;

class EloquentCustomerRepository implements CustomerRepository
{
    public function save(Customer $customer):void
    {
        ModelsCustomer::create([
            'name' => $customer->name,
            'email' => $customer->email
        ]);
    }
}
