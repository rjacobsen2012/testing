<?php

namespace App\Repositories;

use App\Models\Trip;
use Exception;

class TripRepository
{
    public function addTrip(array $tripData)
    {
        $this->verifyTotals();
        return Trip::create($tripData);
    }

    /**
     * @throws Exception
     */
    public function removeTrip(Trip $trip)
    {
        $trip->delete();
        $this->verifyTotals();
    }

    protected function verifyTotals()
    {
        $total = 0;
        /** @var Trip $trip */
        foreach (Trip::orderBy('id', 'asc')->get() as $trip) {
            $total += $trip->miles;
            $trip->total = $total;
            $trip->save();
        }
    }
}
