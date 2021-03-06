@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('createPost') }}" method="post">
            @csrf
                <div class="form-group">
                    <textarea name="status" rows="3"
                              class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                              placeholder="Что у вас нового?"></textarea>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Поделиться</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"><hr>

        @if (!$statuses->count())
            <p>Записей на стене нет</p>
        @else
            @foreach($statuses as $status)
                <div class="media">
                    <a href="{{ route('showProfile', ['username'=> $status->user->username]) }}" class="mr3">
                        @include("layouts.partials.avatar")
                    </a>
                    <div class="media-body">
                        <h4>
                            <a href="{{ route('showProfile', ['username'=> $status->user->username]) }}">
                                {{ $status->user->getUsername() }}</a>
                        </h4>
                        <p>{{ $status->body }}</p>




                            {{--        Комментарии           --}}

                            @foreach($status->replies as $reply)
                                <div class="media">
                                    <a href="{{ route('showProfile', ['username'=> $reply->user->username]) }}" class="mr3">
                                        @include("layouts.partials.avatar")
                                    </a>
                                    <div class="media-body">
                                        <h4>
                                            <a href="{{ route('showProfile', ['username'=> $reply->user->username]) }}">
                                                {{ $reply->user->getUsername() }}</a>
                                        </h4>
                                        <p>{{ $reply->body }}</p>



                            @endforeach

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
                    </div>
                </div>
            @endforeach

            {{ $statuses->links('vendor.pagination.bootstrap-4') }}
        @endif
        </div>
    </div>
@endsection
