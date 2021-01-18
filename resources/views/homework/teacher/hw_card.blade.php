<?php
?>
    <div class="card shadow-sm mb-2 col-md-3">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">{{ $data->last_name }} {{ $data->first_name }}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $data->theme }}</h5>
            <ul class="list-unstyled mt-3 mb-4">
                <li>Задание 1 (фото)</li>
                <li>Задание 2 (Word)</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Проверить</button>
        </div>
    </div>
