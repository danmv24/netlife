@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Запросы в друзья</h3>
            @if (!$requests->count())
                <p>Нет запросов в друзья</p>
            @else
                @foreach ($requests as $user)
                    @include('users.users')
                @endforeach
            @endif
        </div>
    </div>
@endsection
