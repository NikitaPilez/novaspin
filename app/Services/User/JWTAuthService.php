<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Contracts\User\JWTAuthContract;
use App\DTO\Auth\GetUserResultDTO;
use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\LoginResultDTO;
use App\DTO\Auth\RegisterDTO;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class JWTAuthService implements JWTAuthContract
{
    private string $key;

    public function __construct()
    {
        $this->key = env('JWT_SECRET');
    }

    public function register(RegisterDTO $dto): User
    {
        $user = new User();
        $user->name = $dto->name;
        $user->email = $dto->email;
        $user->password = Hash::make($dto->password);
        $user->save();

        return $user;
    }

    public function login(LoginDTO $dto): LoginResultDTO
    {
        $user = User::query()->where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return new LoginResultDTO(isSuccess: false, message: 'Invalid credentials');
        }

        $payload = [
            'iss' => 'jwt-auth',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ];

        return new LoginResultDTO(
            isSuccess: true,
            message: 'Logged in successfully',
            user: $user, token: JWT::encode($payload, $this->key, 'HS256'),
        );
    }

    /**
     * @return GetUserResultDTO
     */
    public function getUser(): GetUserResultDTO
    {
        $jwt = request()->cookie('jwt');

        if (!$jwt) {
            return new GetUserResultDTO(isSuccess: false, message: 'Invalid token');
        }

        try {
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));

            return new GetUserResultDTO(isSuccess: true, user: User::query()->find($decoded->sub));
        } catch (Exception $e) {
            return new GetUserResultDTO(isSuccess: false, message: 'Sometimes wrong');
        }
    }

    public function logout(): void
    {
        Cookie::forget('jwt');
    }
}
