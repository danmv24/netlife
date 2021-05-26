<div class="media mb-2">

    <div class="media-body">
        <a href="{{ route('showProfile', ['username' => $user->username]) }}">
            @if (!$user->avatar)
                <img src="{{ $user->getAvatar() }}"
                     class="avatar mr-3 img-thumbnail rounded-circle"
                     alt="Аватар пользователя" style="width: 70px">
            @else
                <img src="{{ $user->avatarsPath($user->id) . $user->avatar }}"
                     class="avatar avatar-sm mr-3 img-thumbnail rounded-circle"
                     alt="Аватар пользователя" style="width: 70px">
            @endif
        </a>
        <h5 class="mt-0">
            <a href="{{ route('showProfile', ['username' => $user->username]) }}">{{ $user->getUsername() }}</a>
        </h5>

    </div>
</div>
