<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotReply;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;

class RegistrationCommand extends Command
{
    use TelegramBotReply;


    protected $name = 'reg';
    protected $description = 'Регистрация';


    /**
     * @throws TelegramSDKException
     */
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
