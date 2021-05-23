<div class="media mb-2">

    <div class="media-body">
        <a href="{{ route('showProfile', ['username' => $user->username]) }}">
            <img src="{{ $user->getAvatar() }}" class="mr-3" alt="Аватар пользователя">
        </a>
        <h5 class="mt-0">
            <a href="{{ route('showProfile', ['username' => $user->username]) }}">{{ $user->getUsername() }}</a>
        </h5>

    </div>
</div>
