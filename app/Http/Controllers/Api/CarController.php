<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function getCarByVin(string $vin): JsonResponse
    {
        $redisKey = 'vin:' . $vin;
        $carData = Redis::hgetall($redisKey);

        if (!empty($carData)) {
            return response()->json($carData);
        } else {
            return response()->json(['error' => 'Car not found'], 404);
        }
    }
}
