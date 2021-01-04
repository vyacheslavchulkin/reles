<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotBase;
use Telegram\Bot\Commands\Command;

class RegistrationCommand extends Command
{
    use TelegramBotBase;

    protected $name = 'reg';
    protected $description = 'Регистрация';

    public function handle()
    {
        // TODO: Заглушка регистрации
        $buttons = [];
        $code = rand(11111, 999999);
        $text = "Ваш код для реситрации:\n";
        $text .= $code;
        $this->replyWithKeyboard($text, $buttons, true);
    }
}
