<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateUserRequest;
use App\Http\Requests\Dashboard\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * User repository
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Active sidebar item
     *
     * @var string
     */
    private $activeId = 'users';

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Browse all users
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getUsers($request);

        return Inertia::render('Users/Index', ['users' => $users, 'activeId' => $this->activeId]);
    }

    /**
     * Create user page
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/CreateEdit', ['user' => null, 'activeId' => $this->activeId]);
    }

    /**
     * Store new user
     *
     * @param CreateUserRequest $createUserRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        $this->userRepository->createUser($createUserRequest);

        return redirect()->back()->with(makeAlert('info', 'Create successfully.', 'flaticon-like'));
    }

    /**
     * Edit user page
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/CreateEdit', ['user' => $user, 'activeId' => $this->activeId]);
    }

    /**
     * Update user
     *
     * @param User $user
     * @param UpdateUserRequest $updateUserRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, UpdateUserRequest $updateUserRequest)
    {
        $this->userRepository->updateUser($user, $updateUserRequest);

        return redirect()->back()->with(makeAlert('info', 'Update successfully.', 'flaticon-like'));
    }

    /**
     * Delete users
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $this->userRepository->removeUsers($request->ids);

        return redirect()->back()->with(makeAlert('info', 'Deleted successfully.', 'flaticon-like'));
    }
}
