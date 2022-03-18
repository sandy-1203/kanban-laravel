<?php

namespace App\Services;

use App\Helpers\Http\HttpStatuses;
use App\Repositories\Eloquent\CardRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{

    protected $userRepo;
    protected $cardRepo;

    public function __construct(
        UserRepository $userRepo,
        CardRepository $cardRepo
    ) {
        $this->userRepo = $userRepo;
        $this->cardRepo = $cardRepo;
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

    public function listCards($data)
    {
        $accessToken = $data['access_token'];
        $token = PersonalAccessToken::where('token', $accessToken)->first();
        if (!$token) {
            return response()->json([
                'error_code' => HttpStatuses::HTTP_UNAUTHORIZED,
                'message' => 'Invalid token!.'
            ], HttpStatuses::HTTP_UNAUTHORIZED);
        }
        return response()->json($this->cardRepo->listCards($token->tokenable_id, $data));
    }
}
