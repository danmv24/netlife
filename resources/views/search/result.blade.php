@extends('layouts.default')

@section('content')
    <h4>Результаты поиска: "{{ Request::input('query') }}"</h4>

    @if (!$users->count())
        <p>Пользователь не найден</p>
    @else
            <div class="row">
                <div class="col-lg-6">
                    @foreach($users as $user)
                        @include('users.users')
                    @endforeach
                </div>
            </div>
    @endif
@endsection
