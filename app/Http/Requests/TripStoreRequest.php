<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => 'required',
            'miles' => 'required|numeric',
            'car_id' => 'required',
        ];
    }

    public function date()
    {
        return $this->input('date');
    }

    public function miles()
    {
        return $this->input('miles');
    }

    public function carId()
    {
        return $this->input('car_id');
    }
}
