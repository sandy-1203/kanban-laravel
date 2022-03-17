<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class AuthService
{

    protected $userRepo;

    public function __construct(
        UserRepository $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function signIn($data, $ip = null)
    {
        $user = $this->userRepo->findByEmailOrFail($data['email'])->makeVisible(['password']);
        if (!Hash::check($data['password'], $user->getAuthPassword())) {
            throw new UnauthorizedException("Invalid login details!.");
        }
        $token = $user->createToken($ip)->plainTextToken;
        unset($user->password);
        return [
            'access_token' => $token,
            'user' => $user,
        ];
    }

    public function signUp($data, $ip = null)
    {
        $user = $this->userRepo->findByEmail($data['email']);
        if ($user) throw ValidationException::withMessages([
            'email' => sprintf("User with mail: \"%s\" already exists!.", $data['email'])
        ]);
        $user = $this->userRepo->create($data);
        $token = $user->createToken($ip)->plainTextToken;
        return [
            'access_token' => $token,
            'user' => $user,
        ];
    }
}
