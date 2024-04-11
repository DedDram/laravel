<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;


class GetJsonCarDataTest extends TestCase
{
    /**
     * Test the GetJsonCarData command with cars.json
     */
    public function testGetJsonCarDataWithCarsJson()
    {
        // Run the command with the specified URL
        Artisan::call('app:get-json-car-data', ['url' => 'https://rus-trip.ru/cars.json']);

        // Assert that the brand in the database for car with vin=01234567890123456 is 'Kia'
        $this->assertDatabaseHas('cars', ['vin' => '01234567890123456', 'brand' => 'Kia']);

        // Assert that the brand in Redis for car with key 'vin:01234567890123456' is 'Kia'
        $redisBrand = Redis::hget('vin:01234567890123456', 'brand');
        $this->assertEquals('Kia', $redisBrand);
    }

    /**
     * Test the GetJsonCarData command with cars2.json
     */
    public function testGetJsonCarDataWithCars2Json()
    {
        // Run the command with the specified URL
        Artisan::call('app:get-json-car-data', ['url' => 'https://rus-trip.ru/cars2.json']);

        // Assert that the brand in the database for car with vin=01234567890123456 is 'Kia!!!'
        $this->assertDatabaseHas('cars', ['vin' => '01234567890123456', 'brand' => 'Kia!!!']);

        // Assert that the brand in Redis for car with key 'vin:01234567890123456' is 'Kia!!!'
        $redisBrand = Redis::hget('vin:01234567890123456', 'brand');
        $this->assertEquals('Kia!!!', $redisBrand);
    }
}
