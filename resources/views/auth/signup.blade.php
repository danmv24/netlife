@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h3>Регистрация</h3>
            <form method="post" action="{{ route('signUp') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? " is-invalid" : ""}}"
                           id="email" placeholder="example@gmail.com"
                           value="{{ Request::old('email') ?: '' }}">
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Логин</label>
                    <input type="text" name="username" class="form-control{{ $errors->has('username') ? " is-invalid" : ""}}"
                           id="username" placeholder="Имя и Фамилия"
                           value="{{ Request::old('username') ?: '' }}">
                    @if ($errors->has('username'))
                        <span class="help-block text-danger">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? " is-invalid" : ""}}"
                           id="password">
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection
