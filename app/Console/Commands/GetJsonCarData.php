<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class GetJsonCarData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-json-car-data {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve JSON car data from external source and store in database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $url = $this->argument('url');
        $response = Http::get($url);

        if ($response->successful()) {
            $carsData = $response->json();

            foreach ($carsData as $carData) {
                try {
                    $car = Car::updateOrCreate(['vin' => $carData['vin']], $carData);
                    $this->info('Car data successfully retrieved and stored in the database.');
                    try {
                        $redisKey = 'vin:' . $car->vin;
                        $existingCar = Redis::hgetall($redisKey);
                        Redis::hmset($redisKey, $carData);
                        if (!empty($existingCar)) {
                            $this->info('Car data successfully updated in Redis.');
                        } else {
                            // Если машина отсутствует в Redis, добавляем данные
                            $this->info('Car data successfully stored in Redis.');
                        }
                    } catch (\Exception $e) {
                        $this->error('Error while storing car data in Redis: ' . $e->getMessage());
                    }
                } catch (\Exception $e) {
                    $this->error('Error while storing car data in the database: ' . $e->getMessage());
                }
            }
        } else {
            $this->error('Failed to retrieve car data.');
        }
    }
}
