@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Редактирование пользователя</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Назад</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update') }}" method="POST">
        @csrf

        @method('PUT')

        <div class="row">
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Имя:</strong>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>EMail:</strong>
                    <input type="email" name="email" class="form-control"  value="{{ $user->email }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Пароль:</strong>
                    <input type="password" name="password" class="form-control" value="{{ $user->password }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Повторите пароль:</strong>
                    <input type="password" name="password_confirmation" class="form-control" value="{{ $user->password }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Заблокировать:</strong>
                    <input type="checkbox" name="isBlocked" value="{{ $user->isBlocked }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </div>
    </form>
@endsection
