<?php

namespace App\Shared\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasJsonRequestError
{
    public function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors(), 422);
        throw new HttpResponseException($response);
    }
}
