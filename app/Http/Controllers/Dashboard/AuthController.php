<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AuthLoginDashboardRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(
        AuthLoginDashboardRequest $authLoginDashboardRequest,
        AuthRepository $authRepository
    )
    {
        return $authRepository->loginToDashboard($authLoginDashboardRequest);
    }

    public function logout(AuthRepository $authRepository)
    {
        return $authRepository->logoutFromDashboard();
    }
}
