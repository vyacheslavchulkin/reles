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
                <form class="form-group" method="post" action="{{ route('teacher-lesson-store') }}">
                    @csrf
                    <select class="custom-select mb-3" id="subject" name="subject">
                        <option disabled selected>предмет</option>
                        <option value="1">Математика</option>
                        <option value="2">Физика</option>
                        <option value="3">Русский язык</option>
                        <option value="4">История</option>
                    </select>

                    <select class="custom-select mb-3" id="grade" name="grade">
                        <option disabled selected>класс</option>
                        <option value="1">7a</option>
                        <option value="2">8d</option>
                        <option value="3">10a</option>
                    </select>


                    <div class="input-group date mb-3" id="datetimepicker">
                        <input type="text" class="form-control" name="datetime" placeholder="дата и время начала">
                        <div class="input-group-addon input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                    </div>

                    <input type="text" class="form-control mb-3" name="theme" placeholder="тема урока">

                    <input type="text" class="form-control mb-3" name="link" placeholder="ссылка на вебинар">

                    <textarea class="form-control mb-3" name="description"
                              placeholder="дополнительная информация"></textarea>

                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="customFile" name="file">
                        <label class="custom-file-label" for="customFile">загрузить материалы</label>
                    </div>
                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-outline-primary" id="confirm">отправить</button>
                    </div>


                </form>
            </div>
        </div>
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
