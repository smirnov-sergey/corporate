<?php
/**
 * @var $roles App\Role
 * @var $user App\User
 */
?>

<div id="content-page" class="content group">
    <div class="hentry group">
        {!! Form::open([
            'url' => (isset($user->id))
                ? route('admin.users.update', ['users' => $user->id])
                : route('admin.users.store'),
            'class' => 'contact-form',
            'method' => 'POST'
        ]) !!}

        <ul>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Имя:</span>
                    <br/>
                    <span class="sublabel">Имя</span>
                </label>
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-user"></i>
                    </span>
                    {!! Form::text(
                       'name',
                       isset($user->name) ? $user->name : old('name'),
                       ['placeholder' => 'Введите имя']
                    ) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Логин:</span>
                    <br/>
                    <span class="sublabel">Логин</span>
                </label>
                <div class="input-prepend">
                     <span class="add-on">
                          <i class="icon-user"></i>
                        </span>
                    {!! Form::text(
                       'login',
                       isset($user->login) ? $user->login : old('login'),
                       ['placeholder' => 'Введите логин']
                    ) !!}
                </div>
            </li>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Email:</span>
                    <br/>
                    <span class="sublabel">Email</span>
                </label>
                <div class="input-prepend">
                     <span class="add-on">
                          <i class="icon-user"></i>
                        </span>
                    {!! Form::text(
                       'email',
                       isset($user->email) ? $user->email : old('email'),
                       ['placeholder' => 'Введите email']
                    ) !!}
                </div>
            </li>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Пароль:</span>
                    <br/>
                    <span class="sublabel">Пароль</span>
                </label>
                <div class="input-prepend">
                     <span class="add-on">
                          <i class="icon-user"></i>
                        </span>
                    {!! Form::password('password') !!}
                </div>
            </li>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Роль:</span>
                    <br/>
                    <span class="sublabel">Роль</span>
                </label>
                <div class="input-prepend">
                     <span class="add-on">
                          <i class="icon-user"></i>
                        </span>
                    {!! Form::select(
                       'role_id',
                       $roles,
                       isset($user) ? $user->role()->first()->id : null
                    ) !!}
                </div>
            </li>

            @if(isset($user->id))
                <input type="hidden" name="_method" value="PUT">
            @endif

            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-french-1', 'type' => 'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}
    </div>
</div>

