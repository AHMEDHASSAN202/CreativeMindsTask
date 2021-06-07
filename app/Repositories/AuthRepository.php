<?php
/**
 * Created by PhpStorm.
 * User: AQSSA
 */

namespace App\Repositories;


use App\Events\AfterUserLoginToDashboardEvent;
use App\Events\BeforeUserLoginToDashboardEvent;
use App\Events\RegisterUser;
use App\Events\ResendVerifyCodeEvent;
use App\Events\UpdatePhoneWhenUpdatedProfile;
use App\Events\UserAttemptedToDashboardLogin;
use App\Events\UserAttemptedToLogin;
use App\Events\UserNotVerifiedMobileWhenLogin;
use App\Events\UserSuccessLogin;
use App\Http\Requests\API\AuthLoginRequest;
use App\Http\Requests\API\AuthRegisterRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Http\Requests\Dashboard\AuthLoginDashboardRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Models\VerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository
{
    public function login(AuthLoginRequest $authLoginRequest)
    {
        //get user from db
        $user = User::where('mobile', $authLoginRequest->mobile)->user()->first();

        if (!$user) {
            //not found user
            return response()->json(['message' => 'invalid mobile or password'], 401);
        }

        if (!Hash::check($authLoginRequest->password, $user->password)) {
            //if invalid password we will dispatch UserAttemptedToLogin event to handle this case
            event( new UserAttemptedToLogin($user));
            return response()->json(['message' => 'invalid mobile or password'], 401);
        }


        if (!$user->isVerifiedMobile()) {
            //username and password correct but not active
            //we will refresh verification code
            //and resend code
            event(new UserNotVerifiedMobileWhenLogin($user));
            $responseData = ['message' => 'please verify your mobile number', 'redirect_verify_page' => true] + ['profile' => $this->getProfile($user)];
            return response()->json($responseData);
        }

        $token = JWTAuth::fromUser($user);

        event(new UserSuccessLogin($user));

        return response()->json([
                'message'   => 'success login',
                'redirect_verify_page' => false,
                'profile'   => $this->getProfile($user),
                'token'     => $token
            ]
        );
    }

    public function register(AuthRegisterRequest $authRegisterRequest)
    {
        $newUser = User::create([
            'username'   => $authRegisterRequest->username,
            'mobile'     => $authRegisterRequest->mobile,
            'password'   => Hash::make($authRegisterRequest->password),
        ]);

        //dispatch RegisterUser event to refresh verification code and resend it
        event(new RegisterUser($newUser));

        $responseData = ['message' => 'please verify your mobile number', 'redirect_verify_page' => true] + ['profile' => $this->getProfile($newUser)];

        return response()->json($responseData, 201);
    }

    public function getProfile($user)
    {
        return new ProfileResource($user);
    }

    public function profile()
    {
        return response()->json(['profile' => $this->getProfile($this->authUser())]);
    }

    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $me = $this->authUser();

        if ($updateProfileRequest->username) {
            //update username if exists
            $me->username = $updateProfileRequest->username;
        }
        if ($updateProfileRequest->password) {
            //update password if exists
            $me->password = Hash::make($updateProfileRequest->password);
        }
        if ($updateProfileRequest->mobile && $updateProfileRequest->mobile != $me->mobile) {
            //update mobile if exists
            //and set account as inactive
            $me->mobile = $updateProfileRequest->mobile;
            $me->mobile_verified_at = null;
        }

        //update fields
        $me->save();

        if ($me->wasChanged('mobile')) {
            //if change mobile
            //we will refresh verification code and resend it
            event(new ResendVerifyCodeEvent($me));
            //logout current session
            JWTAuth::invalidate(JWTAuth::getToken());
        }

        if ($me->isVerifiedMobile()) {
            $messages = ['message' => 'updated profile', 'redirect_verify_page' => false];
        }else {
            $messages = ['message' => 'please verify your mobile number', 'redirect_verify_page' => true];
        }

        $responseData = $messages + ['profile' => $this->getProfile($me)];

        return response()->json($responseData);
    }

    public function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'success logout']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|digits:5']);

        //get code object
        $code = VerifyCode::where('verify_code', $request->code)->latest()->first();

        if (!$code) {
            //if not found
            return response()->json(['message' => 'verify code not found'], 400);
        }

        if (now()->greaterThan($code->expired_at)) {
            //if code is expired
            return response()->json(['message' => 'this code is expired'], 400);
        }

        //verified account
        $code->user()->update(['mobile_verified_at' => now()]);

        $user = $code->user;

        $token = JWTAuth::fromUser($user);

        //delete used code
        $code->delete();

        return response()->json([
                'message'   => 'account is verified',
                'redirect_verify_page' => false,
                'profile'   => $this->getProfile($user),
                'token'     => $token
            ]
        );
    }

    public function resendCode(Request $request)
    {
        $request->validate(['user_id' => 'required']);

        //get user
        $user = User::where('id', $request->user_id)->user()->whereNull('mobile_verified_at')->first();

        if (!$user) {
            //not found
            return response()->json(['message' => 'user nt found'], 404);
        }

        //dispatch ResendVerifyCodeEvent event
        event(new ResendVerifyCodeEvent($user));

        return response()->json(['message' => 'resend code success']);
    }

    public function loginToDashboard(AuthLoginDashboardRequest $authLoginDashboardRequest)
    {
        //get admin account
        $admin = User::where('username', $authLoginDashboardRequest->username)->admin()->first();
        $errors = new MessageBag();

        //check user
        if (!$admin) {
            //not found
            $errors->add('invalid_login', 'invalid username or password');
            return redirect()->back()->withErrors($errors);
        }

        //check password
        if (!Hash::check($authLoginDashboardRequest->password, $admin->password)) {
            event(new UserAttemptedToDashboardLogin($admin));
            $errors->add('invalid_login', 'invalid username or password');
            return redirect()->back()->withErrors($errors);
        }

        //dispatch before user login event
        event(new BeforeUserLoginToDashboardEvent($admin));

        //logged it
        Auth::guard('dashboard')->login($admin, (boolean)$authLoginDashboardRequest->rememberme);

        //dispatch after user login event
        event(new AfterUserLoginToDashboardEvent($admin));

        return redirect()->route('dashboard.index');
    }

    public function logoutFromDashboard()
    {
        Auth::guard('dashboard')->logout();

        return redirect('/');
    }
}
