<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function toDTO(): RegisterDTO
    {
        return new RegisterDTO(
            email: $this->input('email'),
            name: $this->input('name'),
            password: $this->input('password'),
        );
    }
}
