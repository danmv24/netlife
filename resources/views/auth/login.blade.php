@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h3>Вход</h3>
            <form method="post" action="{{ route('logIn') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? " is-invalid" : ""}}"
                           id="email"
                           value="{{ Request::old('email') ?: '' }}">
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                            {{ $errors->first('email') }}
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
                <div class="custom-control custom-checkbox  mb-3">
                    <input name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label for="remember" class="custom-control-label">Запомнить меня</label>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
@endsection
