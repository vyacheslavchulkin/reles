@section('topMenu')
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal"><a href="/">Smart study</a></h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="/">Главная</a>
            <a class="p-2 text-dark" href="#">Материалы</a>
            <a class="p-2 text-dark" href="{{ route('teacher-lesson') }}">Расписание</a>
            <a class="p-2 text-dark" href="#">Домашние задания</a>
        </nav>

        @guest
            <a class="btn btn-outline-primary mr-3" href="{{ route('login') }}">Войти</a>
            <a class="btn btn-outline-primary mr-3" href="{{ route('register') }}">Регистрация</a>
        @endguest

        @auth
        <a class="btn btn-outline-primary" href="{{ route('logout') }}">Выйти</a>
        @endauth
    </div>
@endsection
