<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Arr;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Passport::actingAs($this->user = factory(User::class)->create());
    }

    public function testCarIndex()
    {
        factory(Car::class, 5)->create();
        $response = $this->get('/api/car');
        $this->assertEquals(5, count($response->json('data')));
    }

    public function testCarStore()
    {
        $car = [
            'model' => $this->faker->name,
        ];

        $response = $this->post('/api/car', $car);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('cars', [
            'model' => Arr::get($car, 'model'),
        ]);

        $car['make'] = $this->faker->name;

        $response = $this->post('/api/car', $car);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('cars', [
            'model' => Arr::get($car, 'model'),
            'make' => Arr::get($car, 'make'),
        ]);

        $car['year'] = $this->faker->year;

        $response = $this->post('/api/car', $car);
        $response->assertJsonPath('data.model', Arr::get($car, 'model'));
        $this->assertDatabaseHas('cars', [
            'model' => Arr::get($car, 'model'),
            'make' => Arr::get($car, 'make'),
            'year' => Arr::get($car, 'year')
        ]);
    }

    public function testCarShow()
    {
        /** @var Car $car */
        $car = factory(Car::class)->create();
        $response = $this->get("/api/car/{$car->id}");
        $response->assertJsonPath('data.id', $car->id);
    }

    public function testCarDestroy()
    {
        /** @var Trip $trip */
        $trip = factory(Trip::class)->create();

        $response = $this->delete("/api/car/{$trip->car->id}");
        $response->assertStatus(403);

        $car = $trip->car;
        $trip->delete();
        $response = $this->delete("/api/car/{$car->id}");
        $response->assertJsonPath('success', true);
        $this->assertDatabaseMissing('cars', [
            'id' => $car->id
        ]);
    }
}
