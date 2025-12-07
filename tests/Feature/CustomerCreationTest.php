<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_customer_can_be_created_via_api(): void
    {
        $customerData = [
            'name' => 'mahmoud Reda',
            'email' => 'mrmrmr033@gmail.com'
        ];

        $response = $this->postJson('/api/v1/customer', $customerData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'name' => 'mahmoud Reda',
            'email' => 'mrmrmr033@gmail.com'
        ]);

        $response->assertJson([

            'message' => 'Successfully Created Customer',
            'data' => [],
            'status' => 201
        ]);
    }


    public function test_customer_creation_fails_with_invalid_data()
    {
        $customerData = [
            'email' => 'mah@gmail.com'
        ];

        $response = $this->postJson('/api/v1/customer', $customerData);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('customers',[
            'email' => 'mah@gmail.com',
        ]);

        $response->assertJsonValidationErrors(['name']);

    }




}
