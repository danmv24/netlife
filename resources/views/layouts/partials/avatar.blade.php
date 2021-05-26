@if (!$status->user->avatar)
    <img src="{{ $status->user->getAvatar() }}"
         class="avatar mr-3 img-thumbnail rounded-circle"
         alt="Аватар пользователя" style="width: 70px">
@else
    <img src="{{ $status->user->avatarsPath($status->user->id) . $status->user->avatar }}"
         class="avatar avatar-sm mr-3 img-thumbnail rounded-circle"
         alt="Аватар пользователя" style="width: 70px">
@endif
