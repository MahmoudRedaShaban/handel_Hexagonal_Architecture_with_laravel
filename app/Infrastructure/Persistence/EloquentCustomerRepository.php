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

    public function find(int $id)
    {
        return ModelsCustomer::findOrFail($id);
    }

    public function paginate(int $perPage)
    {
        return ModelsCustomer::paginate($perPage);
    }

    public function update(int $id, string $name, string $email): void
    {
        $cusotmer = ModelsCustomer::findOrFail($id);
        $cusotmer->update(['name' => $name, 'email' => $email]);
    }

    public function delete(int $id): void
    {
        // ModelsCustomer::findOrFail($id)?->delete();
        ModelsCustomer::findOrFail($id)->delete();
    }
}
