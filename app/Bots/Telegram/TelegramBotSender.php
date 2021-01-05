<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotSenderInterface;
use App\Bots\Telegram\Traits\TelegramBotReply;
use Telegram\Bot\Api;

class TelegramBotSender implements BotSenderInterface
{
    use TelegramBotReply;
    private int $chatId;


    /**
     * SendActions constructor.
     * @param int $chatId
     * @param Api|null $api
     */
    public function __construct(int $chatId, ?Api $api = null)
    {
        $this->telegram = $api ?? new Api();
        $this->chatId = $chatId;
    }
}
