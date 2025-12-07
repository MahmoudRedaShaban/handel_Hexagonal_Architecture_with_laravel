<?php

namespace App\Domain\Customer\Entities;

class Customer
{
    public function __construct(public string $name, public string $email)
    {
    }
}
