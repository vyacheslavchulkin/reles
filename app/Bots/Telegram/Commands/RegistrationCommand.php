<?php


namespace App\Bots\Telegram\Commands;


use Telegram\Bot\Commands\Command;

class RegistrationCommand extends Command
{

    protected $name = 'reg';
    protected $description = 'Регистрация';

    public function handle()
    {
        $this->replyWithMessage([
            "text" => "Регистрация"
        ]); // TODO: Заглушка регистрации
    }
}
