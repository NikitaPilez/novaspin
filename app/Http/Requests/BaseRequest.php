<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(
                data: [
                    'success' => false,
                    'errors' => $validator->errors()->toArray()
                ],
                status: 422
            )
        );
    }
}
