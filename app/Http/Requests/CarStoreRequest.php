<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
        ];
    }

    public function make()
    {
        return $this->input('make');
    }

    public function model()
    {
        return $this->input('model');
    }

    public function year()
    {
        return $this->input('year');
    }
}
