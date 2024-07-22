<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Resources\UserItemResource;
use App\Models\Services\UserService;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * @return Renderable
     */
    public function index() : Renderable
    {
        return view('users.index', ['users' => app(UserService::class)->getList()]);
    }

    /**
     * @return Renderable
     */
    public function create() : Renderable
    {
        return view('users.create');
    }

    /**
     * @param AddUserRequest $request
     * @return RedirectResponse
     */
    public function store(AddUserRequest $request) : RedirectResponse
    {
        app(UserService::class)->add($request);
        return redirect()->route('users.index');
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user) : Renderable
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * @param EditUserRequest $request
     * @return RedirectResponse
     */
    public function update(EditUserRequest $request) : RedirectResponse
    {
        app(UserService::class)->edit($request);
        return redirect()->route('users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        app(UserService::class)->delete($user);
        return redirect()->route('users.index')
            ->with('success','post deleted successfully');

    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function switchBlock(User $user): RedirectResponse
    {
        app(UserService::class)->switchBlock($user);
        return redirect()->route('users.index')
            ->with('success','post blocked successfully');
    }

}
