@extends('layouts.app')
@vite(['resources/css/users.css'])

@section('content')
    <div class="header">
        <h2>Пользователи</h2>
    </div>
    <div class="row">
        <div class="column side"></div>
        <div class="column middle">
            <a href="{{ route('users.create') }}"><button class="button">Добавить пользователя</button></a>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>EMail</th>
                    <th></th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}"><button name="edit">Редактировать</button></a>
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">

                                @csrf
                                @method('DELETE')
                                <button type="submit">Удалить</button>
                            </form>
                            <form action="{{ route('users.switchBlock',$user->id) }}" method="GET">

                                @csrf
                                <button type="submit">@if ($user->is_blocked) Разблокировать @else Заблокировать @endif</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
        <div class="column side"></div>
    </div>
@endsection
