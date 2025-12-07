<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerMangementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

   protected function setUp(): void
   {
    parent::setUp();
   }

   /**
     * Test retrieving a specific customer via the API.
     *
     * @return void
     */
    public function test_customer_can_be_retrieved_via_api()
    {
        $customer = Customer::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        // Add '/api/' prefix
        $response = $this->getJson('/api/v1/customer/' . $customer->id);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Retreved Data Successfully!.',
            'data' => [
                'name' => 'Jane Doe',
                'email' => 'jane.doe@example.com',
            ],
            'status' => 200,
        ]);
    }


   public function test_customer_can_be_updated_via_api()
    {
        $customer = Customer::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $updatedData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ];

        // Add '/api/' prefix
        $response = $this->putJson('/api/v1/customer/' . $customer->id, $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertJson([
            'message' => 'Customer Updated Successfully',
            'data' => [],
            'status' => 200,
        ]);
    }


    public function test_customer_can_be_deleted_via_api()
    {
        $customer = Customer::factory()->create([
            'name' => 'ToDelete',
            'email' => 'delete@example.com',
        ]);

        // Add '/api/' prefix
        $response = $this->deleteJson('/api/v1/customer/' . $customer->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);

        $response->assertJson([
            'message' => 'Customer Deleted Successfully',
            'data' => [],
            'status' => 200,
        ]);
    }

    /**
     * Test retrieving a non-existent customer.
     *
     * @return void
     */
    public function test_non_existent_customer_cannot_be_retrieved()
    {
        // Add '/api/' prefix
        $response = $this->getJson('/api/v1/customer/999');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Retreved Data Faulid!.',
            'data' => [],
            'status' => 200,
        ]);
    }
}
