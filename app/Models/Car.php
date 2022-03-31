<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string model
 * @property string make
 * @property Carbon year
 * @property-read Collection|Trip[] trips
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Car extends Model
{
    protected $guarded = ['id'];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
