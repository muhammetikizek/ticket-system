<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(
        public UserRepository $userRepository
    ) {
    }

    public function index()
    {
        return view('admin.user.index', [
            'users' => $this->userRepository->getUsers(),
            'title' => trans('Users')
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserCreateRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin ?? null,
            'store_ids' => $request->store_ids ?? null,
        ];
        $user = $this->userRepository->createUser($data);
        return redirect()->route('admin.user.index')->with('success', trans('User created successfully'));
    }

    public function edit(User $user)
    {
        if (!$user) {
            return redirect()->back()->with('error', trans('User not found'));
        }
        return view('admin.user.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'store_ids' => $request->store_ids ?? null,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->filled('is_admin')) {
            $data['is_admin'] = $request->is_admin;
        }
        $this->userRepository->updateUser($user, $data);
        return redirect()->back()->with('success', trans('User updated successfully'));
    }
}
