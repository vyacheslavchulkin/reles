<?php
?>
@extends('layouts.main.layout');
@section('content')
    <div class="row-fluid">
        <h2>Домашние задания</h2>
    </div>
    <div class="row-fluid">
        <div class="form form-inline">
            <div class="form-group">
                <label for="group">Класс</label>&nbsp;
                <select name="group" class="form-control">
                    <option value="1">5-А</option>
                    <option value="2">5-Б</option>
                    <option value="3">5-В</option>
                </select>
            </div>
            <div class="form-group" style="margin-left: 10px">
                <label for="leasson">Урок</label>&nbsp;
                <select name="leasson" class="form-control">
                    <option value="1">Урок 1</option>
                    <option value="2">Урок 2</option>
                    <option value="3">Урок 3</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <?php
        $i = 0;
        if (!is_array($homeworks)) {
            throw new Exception('is not array');
        }
        while ($i < count($homeworks)) {
        $row = array_slice($homeworks, $i * 4, 4);
        ?>
        <div class="col-md-12">
            <div class="card-deck text-center mb-2">
                @each('homework.teacher.hw_card',$row,'data')
            </div>
        </div>
        <?php
        $i++;
        }
        ?>
    </div>
@endsection
