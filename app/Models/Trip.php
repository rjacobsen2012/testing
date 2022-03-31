<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @property int id
 * @property Carbon date
 * @property float miles
 * @property float total
 * @property-read Car car
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static|Builder|QueryBuilder|Trip byCar(Car $car)
 * @method static|Builder|QueryBuilder|Trip orderByLatest()
 */
class Trip extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'miles' => 'float',
        'total' => 'float',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param Car $car
     * @return Builder
     */
    public function scopeByCar($query, Car $car)
    {
        return $query->whereHas('car', function ($query) use ($car) {
            $query->where('id', $car->id);
        });
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function scopeOrderByLatest($query)
    {
        return $query->orderBy('id', 'desc');
    }
}
