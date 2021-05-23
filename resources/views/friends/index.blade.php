@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Ваши друзья</h3>
            @if (!$friends->count())
                <p>У Вас нет друзей(((</p>
            @else
                @foreach ($friends as $user)
                    @include('users.users')
                @endforeach
            @endif
        </div>
    </div>
@endsection
