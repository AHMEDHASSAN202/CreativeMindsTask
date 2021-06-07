<?php
/**
 * Created by PhpStorm.
 * User: AQSSA
 */

namespace App\Repositories;

use App\Events\ResendVerifyCodeEvent;
use App\Http\Requests\Dashboard\CreateUserRequest;
use App\Http\Requests\Dashboard\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Get all users
     *
     * @param Request $request
     * @return mixed
     */
    public function getUsers(Request $request)
    {
        $perPage = $request->query('perpage', 10);

        return User::select('id', 'username', 'mobile', 'mobile_verified_at')->latest()->search($request)->user()->paginate($perPage)->appends($request->query());
    }

    /**
     * Create new user
     *
     * @param CreateUserRequest $createUserRequest
     * @return mixed
     */
    public function createUser(CreateUserRequest $createUserRequest)
    {
        $newUser = User::create([
            'username'   => $createUserRequest->username,
            'mobile'     => $createUserRequest->mobile,
            'password'   => Hash::make($createUserRequest->password),
        ]);

        if ($createUserRequest->send_verify_code_now) {
            //if send_verify_code_now field is true
            //we will refresh code and resend it
            event(new ResendVerifyCodeEvent($newUser));
        }

        return $newUser;
    }

    /**
     * Update user
     *
     * @param User $user
     * @param UpdateUserRequest $updateUserRequest
     * @return User
     */
    public function updateUser(User $user, UpdateUserRequest $updateUserRequest)
    {
        if ($updateUserRequest->username) {
            //if username exists
            $user->username = $updateUserRequest->username;
        }
        if ($updateUserRequest->password) {
            //password exists
            $user->password = Hash::make($updateUserRequest->password);
        }
        if ($updateUserRequest->mobile && $updateUserRequest->mobile != $user->mobile) {
            //mobile exists
            //make user inactive
            $user->mobile = $updateUserRequest->mobile;
            $user->mobile_verified_at = null;
        }

        $user->save();

        if ($user->wasChanged('mobile')) {
            //if change mobile
            //we will refresh verification code and resend it
            event(new ResendVerifyCodeEvent($user));
        }

        return $user;
    }

    /**
     * Remove users
     *
     * @param $ids
     * @return int
     */
    public function removeUsers($ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        return User::destroy($ids);
    }
}
