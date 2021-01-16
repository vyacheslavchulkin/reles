@extends('layouts.main.layout')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <h3>Изменить регистрационный данные</h3>
                </div>
                <div class="card-body">
                    <form method="POST" class="js-form" action="{{ route('profile') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">
                                {{ __('Фамилия') }}
                            </label>
                            <div class="col-md-6">
                                <input id="last_name"
                                       type="text"
                                       class="form-control"
                                       name="last_name"
                                       required
                                       value="{{ Auth::user()->last_name }}"
                                       autocomplete="last_name"
                                       autofocus>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">
                                {{ __('Имя') }}
                            </label>
                            <div class="col-md-6">
                                <input id="first_name"
                                       type="text"
                                       class="form-control"
                                       name="first_name"
                                       value="{{ Auth::user()->last_name }}"
                                       required
                                       autocomplete="first_name"
                                       autofocus>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">
                                {{ __('Отчество') }}
                            </label>
                            <div class="col-md-6">
                                <input id="middle_name"
                                       type="text"
                                       class="form-control"
                                       name="middle_name"
                                       value="{{ Auth::user()->last_name }}"
                                       required
                                       autocomplete="middle_name"
                                       autofocus>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">
                                {{ __('Телефон') }}
                            </label>

                            <div class="col-md-6">
                                <input id="phone"
                                       type="phone"
                                       class="form-control"
                                       name="phone"
                                       value="{{ Auth::user()->phone }}"
                                       required
                                       autocomplete="phone"
                                       autofocus>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail адрес</label>
                            <div class="col-md-6">
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       value="{{ Auth::user()->email }}"
                                       autocomplete="email"
                                       required
                                       autofocus>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary js-form-send" value="{{ __('Сохранить') }}">

                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3>Изменить пароль</h3>
                </div>
                <div class="card-body">
                    <form method="POST" class="js-form" action="{{ route('profile') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">
                                Старый пароль
                            </label>
                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password"
                                       required>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">
                                Новый пароль
                            </label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password"
                                       required>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="check_new_password" class="col-md-4 col-form-label text-md-right">
                                Подтверждение нового пароля
                            </label>
                            <div class="col-md-6">
                                <input id="check_new_password" type="password" class="form-control"
                                       name="check_new_password" required>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary js-form-send" value="{{ __('Сохранить') }}">

                            </div>
                        </div>

                    </form>
                </div>
            </div>

            @role('pupil')
            @if (Auth::user()->telegram_chat_id > 0)
                @push('scripts')
                    <script>
                        telegramBotEnaBle = true;
                    </script>
                @endpush
            @endif
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Telegram бот</h3>
                </div>
                <div class="card-body">
                    <span type="submit" class="btn btn-primary js-telegram-del"
                          data-action="{{ route('delTelegramBot') }}">
                            Отключить бота
                    </span>

                    <div class="js-telegram-add">
                        <div class="card-title col-md-10 offset-md-1">
                            Запустите бота, выберите команду "регистрация"
                            <span class="badge badge-secondary">/reg</span>
                            и введите полученный код:
                        </div>
                        <form method="POST" class="js-form-telegram-add" action="{{ route('addTelegramBot') }}">
                            @csrf
                            <div class="form-group row align-middle">

                                <div class="col-md-7 offset-md-1">
                                    <input id="tg_bot_reg_code"
                                           type="text"
                                           class="form-control"
                                           name="tg_bot_reg_code"
                                           required
                                           autofocus>
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" class="btn btn-primary js-form-send"
                                           value="{{ __('Подключить') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
@endsection
