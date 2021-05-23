@extends('layouts.default')

@section('content')
        <div class="row">
            <div class="col-lg-5">
                @include('users.users')
            </div>

            <div class="col-lg-4 col-lg-offset-3">
                <h4>Друзья {{ $user->getUsername() }}</h4>

                @if (!$user->friends()->count())
                    <p>У Вас нет друзей(((</p>
                @else
                    @foreach ($user->friends() as $user)
                        @include('users.users')
                    @endforeach
                @endif

            </div>
        </div>
@endsection
