<?php

namespace App\Models\Services;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Resources\UserItemResource;
use App\Models\Errors\Errors;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{

    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return DB::table('users')
            ->select('id', 'name', 'email', 'password', 'is_blocked')
            ->get();
    }

    /**
     * @param AddUserRequest $user
     * @return array|null
     */
    public function add(AddUserRequest $user): ?array
    {
        try {
            User::create(self::prepareFields($user));
        } catch (QueryException $exception) {
            return $this->setError(Errors::error($exception->getMessage()))->response();
        }

        return $this->response();

    }

    /**
     * @param EditUserRequest $user
     * @return array|null
     */
    public function edit(EditUserRequest $user): ?array
    {
        try {
            User::updateOrCreate([
                'id' => $user['id'],
            ], $this->prepareFields($user));
        } catch (QueryException $exception) {
            return $this->setError(Errors::error($exception->getMessage()))->response();
        }

        return $this->response();
    }

    /**
     * @param User $user
     * @return array|null
     */
    public function delete(User $user): ?array
    {
        try {
            $user->delete();

        } catch (QueryException $exception) {
            return $this->setError(Errors::error($exception->getMessage()))->response();
        }

        return $this->response();
    }

    /**
     * @param User $user
     * @return array|null
     */
    public function switchBlock(User $user): ?array
    {
        try {
            $user->is_blocked = !$user->is_blocked;
            $user->save();

        } catch (QueryException $exception) {
            return $this->setError(Errors::error($exception->getMessage()))->response();
        }

        return $this->response();
    }

    /**
     * @param object $user
     * @return array
     */
    private function prepareFields(object $user): array
    {
        return [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
            'is_blocked' => $user['is_blocked'] ?? false,
        ];
    }
}
