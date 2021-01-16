@extends('layouts.main.layout')

<link rel="stylesheet" href="{{ asset("css/datetimepicker/bootstrap-datetimepicker.min.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

@section('content')
    <div class="row justify-content-center">
        <div class="add-lesson col-6">
            <div class="heading text-center mb-3">
                <h3>Добавить новый урок</h3>
            </div>
            <div class="lesson ">
                <form class="form-group" enctype="multipart/form-data" method="post" action="{{ route('teacher-lesson-store') }}">
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

                    <input type="text" class="form-control mb-3" name="theme" placeholder="тема урока">

                    <textarea class="form-control mb-3" name="description"
                              placeholder="дополнительная информация"></textarea>

                    <input type="file" multiple class="mb-3" id="customFile" name="file">

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-outline-primary" id="confirm">отправить</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("js/datetimepicker/2.26.0_moment.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/bootstrap-datetimepicker.min.js") }}"></script>
    <script src="{{ asset("js/datetimepicker/datepickerconfig.js") }}"></script>
@endpush
