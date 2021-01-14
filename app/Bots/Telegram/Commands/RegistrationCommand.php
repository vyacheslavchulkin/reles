<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotBase;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;

class RegistrationCommand extends Command
{
    use TelegramBotBase;


    protected $name = 'reg';
    protected $description = 'Регистрация';
    private int $chatId;


    /**
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $this->chatId = $this->update->getChat()->id;
        $buttons = [];
        if($this->isRegistered())
        {
            $text = "Вы уже зарегистрированы";
        } else {
            $code = $this->generateCode();
            $text = "Ваш код для реситрации:\n <b>{$code}</b>";
        }
        $this->replyWithKeyboard($text, $buttons, true);
    }
}
