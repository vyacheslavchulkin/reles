@extends('layouts.main.layout')

<link rel="stylesheet" href="{{ asset("css/datetimepicker/bootstrap-datetimepicker.min.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

@section('content')
    <div class="heading text-center mb-3">
        <h3>Расписание</h3>
    </div>
    <div>
        <form action="{{ route('teacher-lesson') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <select class="custom-select mb-3" id="subject" name="subject">
                <option disabled selected>предмет</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <select class="custom-select mb-3" id="grade" name="grade">
                <option disabled selected>класс</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
            <div class="input-group date mb-3" id="datetimepicker">
                <input type="text" class="form-control" name="datetime" placeholder="дата и время начала">
                <div class="input-group-addon input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-outline-primary" id="confirm">показать</button>
            </div>
        </form>

        <form action="{{ route('teacher-lesson-create') }}" method="get" class="text-center">
            <button type="submit" class="btn btn-outline-success" id="confirm">создать урок</button>
        </form>
    </div>
    @php ($i = 1)
    <div class="card-deck">
        @foreach($lessons as $lesson)
            @if($i % 3 === 0)<div class="card-deck">@endif
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $lesson->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $lesson->starts_at }}</h6>
                            <p class="card-text"> {{ $lesson->theme }}</p>
                            <p class="card-text"> {{ $lesson->description }}</p>
                            <a href="#" class="btn btn-outline-primary mb-3">изменить</a>
                            <a href="#" class="btn btn-outline-danger mb-3">удалить</a>
                        </div>
                    </div>
            @if($i % 3 === 0)</div>@endif
            @php ($i++)
        @endforeach
    </div>

@endsection

@push('scripts')
    <script src="{{ asset("js/datetimepicker/jquery-3.5.1.slim.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/popper.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/4.5.0_js_bootstrap.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/2.26.0_moment.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/bootstrap-datetimepicker.min.js") }}"></script>
    <script>
        $(function () {
            $.extend(true, $.fn.datetimepicker.defaults, {
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check-o',
                    clear: 'far fa-trash',
                    close: 'far fa-times'
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker();
        });
    </script>
@endpush
