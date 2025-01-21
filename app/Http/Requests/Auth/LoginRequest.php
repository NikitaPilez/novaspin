<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\DTO\Auth\LoginDTO;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function toDTO(): LoginDTO
    {
        return new LoginDTO(
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
