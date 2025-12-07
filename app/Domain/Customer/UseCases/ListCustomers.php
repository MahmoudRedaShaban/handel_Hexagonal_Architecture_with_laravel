<?php


namespace App\Domain\Customer\UseCases;

use App\Domain\Customer\Repositories\CustomerRepository;

class ListCustomers
{
    public function __construct(private CustomerRepository $repo)
    {
    }
    public function execut(int $perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }
}
