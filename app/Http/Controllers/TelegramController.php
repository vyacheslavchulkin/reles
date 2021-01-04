<?php


namespace App\Http\Controllers;


use App\Bots\Telegram\TelegramBot;
use Exception;
use Illuminate\Support\Facades\Log;

class TelegramController
{
    public function webhook()
    {
        try {
            $bot = new TelegramBot();
            $bot->run();
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
