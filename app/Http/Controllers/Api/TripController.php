<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\TripStoreRequest;
use App\Http\Controllers\Resources\TripResource;
use App\Models\Trip;
use App\Repositories\TripRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    /** @var TripRepository */
    protected $tripRepository;

    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAll', [Trip::class]);

        return TripResource::collection(Trip::orderByLatest()->get());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(TripStoreRequest $request): TripResource
    {
        $this->authorize('store', [Trip::class]);

        return new TripResource($this->tripRepository->addTrip([
            'date' => Carbon::parse($request->date()),
            'miles' => $request->miles(),
            'car_id' => $request->carId(),
        ]));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Trip $trip): TripResource
    {
        $this->authorize('view', [Trip::class, $trip]);

        return new TripResource($trip);
    }

    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Trip $trip): JsonResponse
    {
        $this->authorize('delete', [Trip::class, $trip]);

        $this->tripRepository->removeTrip($trip);

        return response()->json(['success' => true]);
    }
}
