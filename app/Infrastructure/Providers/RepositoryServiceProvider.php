<?php

namespace App\Infrastructure\Providers;

use App\Domain\Customer\Repositories\CustomerRepository;
use App\Infrastructure\Persistence\EloquentCustomerRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // bind interface ->  implementation
        $this->app->bind(CustomerRepository::class, EloquentCustomerRepository::class);
    }
}
