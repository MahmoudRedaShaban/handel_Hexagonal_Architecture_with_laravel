<?php

namespace App\Domain\Customer\Repositories;

use App\Domain\Customer\Entities\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
    public function update(int $id, string $name, string $email): void;
    public function delete(int $id): void;
    public function find(int $id);
    public function paginate(int $perPage);
}
