@extends('layouts.main.layout')

<link rel="stylesheet" href="{{ asset("css/datetimepicker/bootstrap-datetimepicker.min.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

@section('content')
    <div class="heading text-center mb-3">
        <h3>Расписание</h3>
    </div>
    <div>
        <form action="{{ route('teacher-lesson-filter') }}" method="post">
            @csrf
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
    @foreach($lessons as $lesson)
    @if($loop->index % 3 === 0 && !$loop->first)</div>@endif
    @if($loop->index % 3 === 0)
        <div class="row mt-3 justify-content-center">@endif
            <div class="col col-md-8 col-xl-4 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $lesson->sname }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $lesson->starts_at }}</h6>
                        <p class="card-text text-truncate"> {{ $lesson->theme }}</p>
                        <p class="card-text text-truncate"> {{ $lesson->description }}</p>
                        <a href="{{ route('teacher-lesson-update', $lesson->id) }}" class="btn btn-outline-primary mb-3">изменить</a>
                        <a href="{{ route('teacher-lesson-delete', $lesson->id) }}" class="btn btn-outline-danger mb-3">удалить</a>
                    </div>
                </div>
            </div>

            @if($loop->last)</div>@endif
    @endforeach

@endsection

@push('scripts')
    <script src="{{ asset("js/datetimepicker/2.26.0_moment.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/bootstrap-datetimepicker.min.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/datepickerconfig.js") }}"></script>
@endpush
