<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Http\HttpStatuses;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\DbDumper\Databases\MySql;

class AuthController extends BaseApiController
{

    private $authService;

    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    public function signIn(SignInRequest $request)
    {
        $data = $request->validated();
        $loginInfo = $this->authService->signIn($data, $request->ip());
        return $this->respond($loginInfo, HttpStatuses::HTTP_OK, "User successfully signed-in!.");
    }

    public function signUp(SignUpRequest $request)
    {
        $data = $request->validated();
        return $this->respond(
            $this->authService->signUp($data, $request->ip()),
            HttpStatuses::HTTP_OK,
            "User successfully signed-in!."
        );
    }

    public function profile(Request $request)
    {
        return $this->respond(['user' => $request->user(),]);
    }

    public function exportDb()
    {
        $fileName = 'dump.sql';
        $filePath = Storage::path($fileName);

        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($filePath);
        return Response::download($filePath);
    }

    public function listCards(Request $request)
    {
        $data = $request->all();
        return $this->authService->listCards($data);
    }
}
