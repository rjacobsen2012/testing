<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarStoreRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarWithDetailsResource;
use App\Models\Car;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAll', [Car::class]);

        return CarResource::collection(Car::all());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CarStoreRequest $request): CarResource
    {
        $this->authorize('store', [Car::class]);

        return new CarResource(Car::create([
            'make' => $request->make(),
            'model' => $request->model(),
            'year' => $request->year(),
        ]));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Car $car): CarWithDetailsResource
    {
        $this->authorize('view', [Car::class, $car]);

        return new CarWithDetailsResource($car);
    }

    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Car $car): JsonResponse
    {
        $this->authorize('delete', [Car::class, $car]);
        $car->delete();

        return response()->json(['success' => true]);
    }
}
