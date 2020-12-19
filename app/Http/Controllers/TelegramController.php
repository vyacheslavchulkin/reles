<?php


namespace App\Http\Controllers;


use App\Bots\Telegram\Helpers;
use App\Bots\Telegram\TelegramBot;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramController
{
    public function webhook()
    {
        $bot = new TelegramBot();
        $bot->run();
    }


    public function setWebhook(): string
    {
        try {
            return (new Helpers())->setWebhookUrl() ? "OK" : "Ne ok";
        } catch (TelegramSDKException $e) {
            return "Error";
        } // TODO Написать апишку, для настройки URL вебхука из админки
    }
}
