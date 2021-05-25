<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">

        <a class="navbar-brand" href="{{ route('homePage') }}">NetLife</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if (\Illuminate\Support\Facades\Auth::check())
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homePage') }}">Стена</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('showFriend') }}">Друзья</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('allRequests') }}">Запросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Сообщения</a>
                    </li>
                </ul>
                <form action="{{ route('search') }}" class="d-flex" method="get">
                    <input name="query"  class="form-control me-2" type="search" placeholder="Поиск" aria-label="Search">
                    <button class="btn btn-success" type="submit">Найти</button>
                </form>
            @endif
            <ul class="navbar-nav ml-auto">
                @if (\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item"><a href="{{ route('showProfile', ['username' => Auth::user()->username]) }}" class="nav-link">{{ Auth::user()->getUsername() }}</a></li>
                    <li class="nav-item"><a href="{{ route('editProfile') }}" class="nav-link">Обновить профиль</a></li>
                    <li class="nav-item"><a href="{{ route('logOut') }}" class="nav-link">Выйти</a></li>
                @else
                        <li class="nav-item"><a href="{{ route('signUp') }}" class="nav-link">Регистрация</a></li>
                        <li class="nav-item"><a href="{{ route('logIn') }}" class="nav-link">Войти</a></li>
                @endif
            </ul>
        </div>

    </div>
</nav>
