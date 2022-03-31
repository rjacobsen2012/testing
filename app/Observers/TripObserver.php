<?php

namespace App\Observers;

use App\Models\Trip;

class TripObserver
{
    public function saving(Trip $trip)
    {
        $trip->total = $trip->total ?: Trip::where('id', '!=', $trip->id)->sum('miles') + $trip->miles;
    }
}
