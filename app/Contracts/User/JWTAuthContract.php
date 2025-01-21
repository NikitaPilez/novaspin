<?php

namespace App\Contracts\User;

use App\DTO\Auth\GetUserResultDTO;
use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\LoginResultDTO;
use App\DTO\Auth\RegisterDTO;
use App\Models\User;

interface JWTAuthContract
{
    public function register(RegisterDTO $dto): User;
    public function login(LoginDTO $dto): LoginResultDTO;
    public function getUser(): GetUserResultDTO;
    public function logout(): void;
}
