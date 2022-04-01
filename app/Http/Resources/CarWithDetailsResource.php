<?php

namespace App\Http\Resources;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Http\Resources\Json\JsonResource;

class CarWithDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Car $car */
        $car = $this->resource;
        $trips = Trip::byCar($car);

        return [
            'id' => $car->id,
            'make' => $car->make,
            'model' => $car->model,
            'year' => $car->year,
            'trip_count' => $trips->count(),
            'trip_miles' => $trips->sum('miles'),
        ];
    }
}
