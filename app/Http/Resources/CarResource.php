<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Car $car */
        $car = $this->resource;

        return [
            'id' => $car->id,
            'make' => $car->make,
            'model' => $car->model,
            'year' => $car->year,
        ];
    }
}
