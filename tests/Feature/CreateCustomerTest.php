<?php

namespace Tests\Unit\Domain\Customer\UseCases;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepository;
use App\Domain\Customer\UseCases\CreateCustomer;
use PHPUnit\Framework\TestCase; // Use PHPUnit's TestCase for unit tests
use Mockery; // For mocking interfaces

class CreateCustomerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close(); // Clean up Mockery mocks after each test
        parent::tearDown();
    }

    /**
     * Test that the CreateCustomer use case can successfully create a customer.
     *
     * @return void
     */
    public function test_create_customer_use_case_can_create_a_customer()
    {
        // 1. Arrange: Set up the dependencies and expected behavior

        // Create a mock for the CustomerRepository interface.
        // This mock will simulate the behavior of the real repository without
        // actually interacting with a database or other infrastructure.
        $mockCustomerRepository = Mockery::mock(CustomerRepository::class);

        // Expect the 'save' method to be called once on the repository.
        // It should receive an instance of the Customer entity.
        // We'll tell the mock to return a Customer entity when 'save' is called,
        // simulating a successful persistence.
        $mockCustomerRepository->shouldReceive('save')
                               ->once()
                               ->withArgs(function (Customer $customer) {
                                   // Assertions inside withArgs verify the entity passed to save
                                   $this->assertEquals('John Doe', $customer->name);
                                   $this->assertEquals('john.doe@example.com', $customer->email);
                                   return true; // Return true if arguments match expectations
                               })
                               ->andReturnUsing(function (Customer $customer) {
                                   // Simulate the repository returning the saved entity with an ID
                                   $customer->id = 1; // Assign a dummy ID
                                   return $customer;
                               });

        // Instantiate the Use Case, injecting the mocked repository.
        $createCustomerUseCase = new CreateCustomer($mockCustomerRepository);

        // 2. Act: Call the method being tested
        $customerName = 'John Doe';
        $customerEmail = 'john.doe@example.com';
        $createdCustomer = $createCustomerUseCase->execute($customerName, $customerEmail);

        // The use case does not return a Customer instance; it performs the creation via the repository.
        // Assertions are handled by the mock expectations set above.
    }

    /**
     * Test that the CreateCustomer use case handles duplicate email (if that logic was in the use case).
     * This example assumes validation happens before, but demonstrates how to mock exceptions.
     *
     * @return void
     */
    public function test_create_customer_use_case_throws_exception_on_duplicate_email()
    {
        // This test would be more relevant if your CreateCustomer use case itself
        // contained logic to check for duplicate emails or handled exceptions
        // from the repository. For now, it's a structural example.

        $mockCustomerRepository = Mockery::mock(CustomerRepository::class);

        // Simulate the repository throwing an exception if a duplicate email is detected.
        // In a real scenario, the repository might throw a specific custom exception.
        $mockCustomerRepository->shouldReceive('save')
                               ->once()
                               ->andThrow(new \Exception('Duplicate email detected!'));

        $createCustomerUseCase = new CreateCustomer($mockCustomerRepository);

        $this->expectException(\Exception::class); // Expect a generic exception for this example
        $this->expectExceptionMessage('Duplicate email detected!');

        $createCustomerUseCase->execute('Jane Doe', 'duplicate@example.com');
    }
}
