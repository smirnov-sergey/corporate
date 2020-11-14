<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticlesRepository;
use App\Repositories\PermissionsRepository;
use App\Repositories\RolesRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class PermissionsController extends AdminController
{
    /**
     * @var PermissionsRepository
     */
    protected $per_rep;
    /**
     * @var RolesRepository
     */
    protected $rol_rep;

    public function __construct(PermissionsRepository $per_rep, RolesRepository $rol_rep)
    {
        parent::__construct();

        if (Gate::allows('EDIT_USERS')) {
            abort(403);
        }

        if (!Gate::denies('VIEW_ADMIN_ARTICLES')) {
            abort(403);
        }

        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;
        $this->template = config('settings.theme') . '.admin.permissions';
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $this->title = 'Менеджер прав пользователей';

        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $this->content = view(config('settings.theme') . '.admin.permissions_content')
            ->with([
                'roles' => $roles,
                'permissions' => $permissions
            ])
            ->render();

        return $this->renderOutput();
    }

    private function getRoles()
    {
        $roles = $this->rol_rep->get();

        return $roles;
    }

    private function getPermissions()
    {
        $permissions = $this->per_rep->get();

        return $permissions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->per_rep->changePermissions($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return back()->with($result);
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
