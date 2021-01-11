<?php


namespace App\Bots\Telegram\Traits;


use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Traits\Telegram;

trait TelegramBotBase
{
    use Answerable;
    use TelegramBotHomework;
    use TelegramBotRedis;
    use TelegramBotReply;
    use TelegramBotRegistration;
    use Telegram;


    /**
     * @return bool
     */
    private function checkCallBackData(): bool
    {
        return ($this->update->detectType() == "callback_query");
    }


    private function callbackQueryParser(): array
    {
        $query = (string)$this->update->callbackQuery->data;
        $explode = explode("_", $query);
        return [
            "type" => $explode[0],
            "id" => (string)$explode[1],
        ];
    }


    private function isCommand(): bool
    {
        $text = $this->messageText;
        if (substr($text, 0, 1) == "/") {
            $command = explode(" ", substr($text, 1))[0];
            return array_key_exists(trim($command), $this->telegram->getCommands());
        }
        return false;
    }
}
