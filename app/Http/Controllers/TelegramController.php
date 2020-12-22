<?php


namespace App\Http\Controllers;


use App\Bots\Telegram\TelegramBot;

class TelegramController
{
    public function webhook()
    {
        $bot = new TelegramBot();
        $bot->run();
    }
}
