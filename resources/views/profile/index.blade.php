@extends('layouts.default')

@section('content')
        <div class="row">
            <div class="col-lg-5">
                @include('users.users')
            </div>

            <div class="col-lg-4 col-lg-offset-3">

                @if (Auth::user()->hasFriendRequestsPending($user))
                    <p>В ожидании подтверждения запроса в друзья</p>
                @elseif (Auth::user()->hasFriendRequestReceived($user))
                    <a href="#" class="btn btn-primary mb-2">Подтвердить запрос</a>
                @elseif(Auth::user()->isFriendWith($user))
                    {{ $user->getUsername() }} у вас в друзьях
                @else
                    <a href="{{ route('add', ['username' => $user->username]) }}"
                       class="btn btn-primary mb-2">Добавить в друзья</a>
                @endif

                <h4>Друзья {{ $user->getUsername() }}</h4>

                @if (!$user->friends()->count())
                    <p>У {{ $user->getUsername() }} нет друзей(((</p>
                @else
                    @foreach ($user->friends() as $user)
                        @include('users.users')
                    @endforeach
                @endif

            </div>
        </div>
@endsection
