<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\RolesRepository;
use App\Repositories\UsersRepository;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UsersController extends AdminController
{
    /**
     * @var UsersRepository
     */
    protected $us_rep;
    /**
     * @var RolesRepository
     */
    protected $rol_rep;


    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep)
    {
        parent::__construct();

        if (Gate::allows('EDIT_USERS')) {
            abort(403);
        }

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;

        $this->template = config('settings.theme') . '.admin.users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $users = $this->us_rep->get();

        $this->content = view(config('settings.theme') . '.admin.users_content')
            ->with('users', $users)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function create()
    {
        $this->title = 'Новый пользователь';

        $tmp_roles = $this->getRoles();
        $roles = $tmp_roles->reduce(function ($return_roles, $role) {
            $return_roles[$role->id] = $role->name;

            return $return_roles;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.users_create_content')
            ->with(['roles' => $roles])
            ->render();

        return $this->renderOutput();
    }

    private function getRoles()
    {
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Requests\UserRequest $request)
    {
        $result = $this->us_rep->addUser($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function edit(User $user)
    {
        $this->title = 'Редактирование пользователя' . $user->name;

        $tmp_roles = $this->getRoles();
        $roles = $tmp_roles->reduce(function ($return_roles, $role) {
            $return_roles[$role->id] = $role->name;

            return $return_roles;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.users_create_content')
            ->with([
                'roles' => $roles,
                'user' => $user,
            ])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Requests\UserRequest $request, User $user)
    {
        $result = $this->us_rep->updateUser($request, $user);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $result = $this->us_rep->deleteUser($user);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }
}
