@extends('layouts.default')

@section('content')
        <div class="row">
            <div class="col-lg-5">
                @include('users.users')
                <hr>

                @if (!$statuses->count())
                    <p>У {{ $user->getUsername() }} нет записей</p>
                @else
                    @foreach($statuses as $status)
                        <div class="media">
                            <a href="{{ route('showProfile', ['username'=> $status->user->username]) }}" class="mr3">
                                <img src="{{ $status->user->getAvatar() }}" alt="{{ $status->user->getUsername() }}"
                                     class="media-object rounded">
                            </a>
                            <div class="media-body">
                                <h4>
                                    <a href="{{ route('showProfile', ['username'=> $status->user->username]) }}">
                                        {{ $status->user->getUsername() }}</a>
                                </h4>
                                <p>{{ $status->body }}</p>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="#">Лайк</a>
                                    </li>
                                    <li class="list-inline-item">10 лайков</li>
                                </ul>



                                {{--        Комментарии           --}}

                                @foreach($status->replies as $reply)
                                    <div class="media">
                                        <a href="{{ route('showProfile', ['username'=> $reply->user->username]) }}" class="mr3">
                                            <img src="{{ $reply->user->getAvatar() }}" alt="{{ $reply->user->getUsername() }}"
                                                 class="media-object rounded">
                                        </a>
                                        <div class="media-body">
                                            <h4>
                                                <a href="{{ route('showProfile', ['username'=> $reply->user->username]) }}">
                                                    {{ $reply->user->getUsername() }}</a>
                                            </h4>
                                            <p>{{ $reply->body }}</p>
                                            <ul class="list-inline">

                                                <li class="list-inline-item">
                                                    <a href="#">Лайк</a>
                                                </li>
                                                <li class="list-inline-item">10 лайков</li>
                                            </ul>
                                @endforeach


                                            @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                                                <form action="{{ route('reply', ['feedId' => $status->id]) }}"
                                                      method="post" class="mb-4">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="reply-{{ $status->id }}" rows="3"
                                                                  class="form-control{{ $errors->has("reply-{ $status->id }") ? ' is-invalid' : '' }}"
                                                                  placeholder="Прокоментировать запись"></textarea>
                                                        @if ($errors->has("reply-{ $status->id }"))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first("reply-{ $status->id }") }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm mt-3">Отправить</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                    @endforeach


                @endif

            </div>

            <div class="col-lg-4 col-lg-offset-3">

                @if (Auth::user()->hasFriendRequestsPending($user))
                    <p>В ожидании подтверждения запроса в друзья</p>
                @elseif (Auth::user()->hasFriendRequestReceived($user))
                    <a href="{{ route('accept', ['username' => $user->username]) }}"
                       class="btn btn-primary mb-2">Подтвердить запрос</a>
                @elseif(Auth::user()->isFriendWith($user))
                    {{ $user->getUsername() }} у вас в друзьях

                    <form action="{{ route('deleteFriend', ['username' => $user->username]) }}" method="post">
                        @csrf
                        <input type="submit" value="Удалить из друзей" class="btn btn-danger my-2">
                    </form>
                @elseif (Auth::user()->id !== $user->getId())
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
