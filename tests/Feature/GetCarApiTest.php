<?php

namespace Tests\Feature;

use Tests\TestCase;


class GetCarApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_car_by_vin()
    {
        // Checking the query for the VIN that is in Redis
        $response = $this->get('/api/cars/78901234567890123');
        $response->assertStatus(200)
            ->assertJson([
                'vin' => '78901234567890123',
                'brand' => 'Audi',
                'model' => 'A4',
                'year' => '2016',
                'color' => 'White',
                'mileage' => '60000',
                'kpp' => 'Automatic',
                'fuel_type' => 'Diesel',
                'price' => '23000',
            ]);

        // Checking the request for a VIN that is not in Redis
        $response = $this->get('/api/cars/7898887890123');
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Car not found',
            ]);
    }
}
