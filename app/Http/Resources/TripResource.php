<?php

namespace App\Http\Resources;

use App\Models\Trip;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Trip $trip */
        $trip = $this->resource;

        return [
            'id' => $trip->id,
            'date' => $trip->date->format('m/d/Y'),
            'miles' => $trip->miles,
            'total' => $trip->total,
            'car' => new CarResource($trip->car),
        ];
    }
}
