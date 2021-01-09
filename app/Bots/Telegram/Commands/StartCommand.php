<?php

namespace App\Bots\Telegram\Commands;

use App\Bots\Telegram\Traits\TelegramBotBase;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;


class StartCommand extends Command
{
    use TelegramBotBase;


    protected $name = 'start';
    protected $description = 'Запуск бота';


    /**
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $buttons = [];
        if ($this->isRegistered()) {
            $buttons[] = [["text" => "Сдать домашнюю работу", "callback_data" => "cmd_hw"]];
            $buttons[] = [["text" => "Расписание уроков", "callback_data" => "cmd_sch"]];
        } else {
            $buttons[] = [["text" => "Регистраниция", "callback_data" => "cmd_reg"]];
        }
        $buttons[] = [["text" => "Помощь", "callback_data" => "cmd_help"]];
        $text = "Что будем делать?\n";
        $this->replyWithKeyboard($text, $buttons);
    }
}
