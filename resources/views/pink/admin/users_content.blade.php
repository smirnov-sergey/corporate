<?php
/**
 * @var $users App\User
 * @var $user App\User
 */
?>

<div id="content-page" class="content group">
    <div class="hentry group">
        <h2>Пользователи</h2>
        <div class="short-table white">
            <table style="width: 100%" cellspacing="0" cellpadding="0">
                <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Login</th>
                <th>Role</th>
                <th>Удалить</th>
                </thead>

                @if($users)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{!! Html::link(route('admin.users.edit', ['users' => $user->alias])) !!}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->roles->implode('name', ', ') }}</td>
                            <td>
                                {!! Form::open([
                                    'url' => route('admin.users.destroy', ['users' => $user->alias]),
                                    'class' => 'form-horizontal',
                                    'method' => 'POST'
                                ]) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        {!! Html::link(
            route('admin.users.create'),
            'Добавить пользователя',
            ['class' => 'btn btn-french-1']
        ) !!}
    </div>
</div>

