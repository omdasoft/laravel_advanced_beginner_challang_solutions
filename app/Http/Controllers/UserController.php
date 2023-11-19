<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\UserValidationService;
use App\Http\Requests\StoreUserRequest;
class UserController extends Controller {
    
    protected $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }
    
    public function index(Request $request) 
    {
        $users = $this->userService->users($request['view_deleted']);
        return view('users.index', compact('users'));
    }

    public function create() 
    {
        $roles = $this->userService->roles();
        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request) 
    {
        $this->userService->store($request->validated());
        return redirect()->route('admin.users.index');
    }
    
    public function edit(User $user)
    {
        $roles = $this->userService->roles();
        return view('users.edit', compact('user', 'roles'));
    }
    
    public function update(StoreUserRequest $request, $id)
    {
        $this->userService->upsert($request->all(), $id);
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function restore($id) {
        $this->userService->restore($id);
        return back();
    }

    public function restoreAll() {
        $this->userService->restoreAll();
        return back();
    }

    public function forceDelete($id) {
        $this->userService->forceDelete($id);
        return back();
    }

    public function forceDeleteAll() {
        $this->userService->forceDeleteAll();
        return back();
    }
}
