<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthLoginRequest;
use App\Http\Requests\API\AuthRegisterRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    /**
     * Auth repository
     *
     * @var AuthRepository
     */
    private $authRepository;

    /**
     * AuthController constructor.
     *
     * @param AuthRepository $authRepository
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Login user
     *
     * @param AuthLoginRequest $authLoginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $authLoginRequest)
    {
        return $this->authRepository->login($authLoginRequest);
    }

    /**
     * Register new user
     *
     * @param AuthRegisterRequest $authRegisterRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRegisterRequest $authRegisterRequest)
    {
        return $this->authRepository->register($authRegisterRequest);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->authRepository->logout();
    }

    /**
     * Get Profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->authRepository->profile();
    }

    /**
     * Update Profile
     *
     * @param UpdateProfileRequest $updateProfileRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        return $this->authRepository->updateProfile($updateProfileRequest);
    }

    /**
     * Handle verification code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(Request $request)
    {
        return $this->authRepository->verifyCode($request);
    }

    /**
     * Resend verification code by [user id]
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerifyCode(Request $request)
    {
        return $this->authRepository->resendCode($request);
    }
}
