<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TripTest extends TestCase
{
    /** @var Carbon */
    protected $now;

    protected function setUp(): void
    {
        parent::setUp();
        Passport::actingAs($this->user = factory(User::class)->create());
        Carbon::setTestNow($this->now = Carbon::now());
    }

    public function testTripIndex()
    {
        factory(Trip::class, 5)->create();
        $response = $this->get('/api/trip');
        $this->assertEquals(5, count($response->json('data')));
    }

    public function testTripStore()
    {
        $trip = [
            'date' => $this->now,
        ];

        $response = $this->post('/api/trip', $trip);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('trips', [
            'date' => Arr::get($trip, 'date'),
        ]);

        $trip['miles'] = $this->faker->randomFloat(2, 0, 20);

        $response = $this->post('/api/trip', $trip);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('trips', [
            'date' => Arr::get($trip, 'date'),
            'miles' => Arr::get($trip, 'miles'),
        ]);

        $trip['car_id'] = $carId = factory(Car::class)->create()->getKey();

        $response = $this->post('/api/trip', $trip);
        $response->assertJsonPath('data.car.id', $carId);
        $this->assertDatabaseHas('trips', [
            'date' => Arr::get($trip, 'date'),
            'miles' => Arr::get($trip, 'miles'),
            'total' => Arr::get($trip, 'miles'),
            'car_id' => $carId,
        ]);
    }

    public function testTripShow()
    {
        /** @var Trip $trip */
        $trip = factory(Trip::class)->create();
        $response = $this->get("/api/trip/{$trip->id}");
        $response->assertJsonPath('data.id', $trip->id);
    }

    public function testTripDestroy()
    {
        /** @var Trip $trip */
        $trip = factory(Trip::class)->create();
        $response = $this->delete("/api/trip/{$trip->id}");
        $response->assertJsonPath('success', true);
        $this->assertDatabaseMissing('trips', [
            'id' => $trip->id
        ]);
    }
}
