@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Редактирование профиля</h3>

            <form method="post" action="{{ route('editProfile') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Ваш Логин</label>
                    <input type="text" name="username" class="form-control{{ $errors->has('username') ? " is-invalid" : ""}}"
                           id="username"
                           value="{{ Request::old('username') ?: Auth::user()->username }}">
                    @if ($errors->has('username'))
                        <span class="help-block text-danger">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

        </div>
    </div>
@endsection
