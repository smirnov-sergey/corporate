<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        if (Gate::allows('VIEW_ADMIN')) {
            abort(403);
        }

        $this->template = config('settings.theme') . '.admin.index';
    }

    public function index()
    {
        $this->title = 'Панель администратора';

        return $this->renderOutput();
    }
}
