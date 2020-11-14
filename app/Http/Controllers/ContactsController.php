<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    public function __construct()
    {
        parent:: __construct(new MenusRepository(new Menu()));

        $this->bar = 'left';
        $this->template = config('settings.theme') . '.contacts';
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'email' => 'Поле :attribute должно содержать правильный email',
            ];

            $this->validate($request,
                [
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'text' => 'required',
                ],
                $messages);

            $data = $request->all();

            $result = Mail::send(config('settings.theme') . '.email', ['data' => $data], function ($m) use ($data) {
                $mail_admin = env('MAIL_ADMIN');

                $m->from($data['email'], $data['name']);
                $m->to($mail_admin, 'Mr. Admin')
                    ->subject('Question');
            });

            if ($result) {
                return redirect()->route('contacts')
                    ->with('status', Lang::get('ru.email_is_send'));
            }
        }

        $this->title = 'Контакты';

        $content = view(config('settings.theme') . '.contact_content')
            ->render();

        $this->vars = array_add($this->vars, 'content', $content);

        $this->content_left_bar = view(config('settings.theme') . '.contact_bar')
            ->render();

        return $this->renderOutput();
    }
}
