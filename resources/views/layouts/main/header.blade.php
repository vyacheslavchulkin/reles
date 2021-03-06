@section('topMenu')
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal"><a href="/">RELES</a></h5>
        @guest
            <a class="btn btn-outline-primary mr-3" href="{{ route('login') }}">Войти</a>
            <a class="btn btn-outline-primary mr-3" href="{{ route('register') }}">Регистрация</a>
        @endguest

        @auth
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark" href="/">Главная</a>
                <a class="p-2 text-dark" href="#">Материалы</a>
                <a class="p-2 text-dark" href="{{ route('teacher-lesson') }}">Расписание</a>
                <a class="p-2 text-dark" href="{{ route('teacher-homework') }}">Домашние задания</a>
            </nav>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark"
                   href="#"
                   id="navbarDropdownMenuLink"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                {{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-dark" href="{{ route('profile') }}">Профиль</a>
                    <a class="dropdown-item text-primary" href="{{ route('logout') }}">Выйти</a>
                </div>
            </div>
        @endauth
    </div>
@endsection
