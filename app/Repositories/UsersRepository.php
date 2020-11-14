<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Gate;

class UsersRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function addUser($request)
    {
        if (Gate::allows('create', $this->model)) {
            abort(403);
        }

        $data = $request->all();

        // example2: $user = $this->model->create([
        $user = User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if ($user) {
            $user->roles()->attach($data['role_id']);
        }

        return ['status' => 'Пользователь добавлен'];
    }

    public function updateUser($request, $user)
    {
        if (Gate::allows('edit', $this->model)) {
            abort(403);
        }

        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->fill($data)->update();
        $user->roles()->sync($data['role_id']);

        return ['status' => 'Пользователь добавлен'];
    }

    public function deleteUser($user)
    {
        if (Gate::allows('delete', $this->model)) {
            abort(403);
        }

        $user->roles()->detach();

        if ($user->delete()) {
            return ['status' => 'Пользователь удален'];
        }
    }
}