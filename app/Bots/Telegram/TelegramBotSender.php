<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotSenderInterface;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBotSender implements BotSenderInterface
{
    private Api $api;
    private int $chatId;


    /**
     * SendActions constructor.
     * @param int $chatId
     * @param Api|null $api
     */
    public function __construct(int $chatId, ?Api $api = null)
    {
        $this->api = $api ?? new Api();
        $this->chatId = $chatId;
    }


    /**
     * @throws TelegramSDKException
     */
    public function typing(): void
    {
        $this->api->sendChatAction(["chat_id" => $this->chatId, "action" => "typing"]);
    }


    /**
     * @param string $text
     * @return int
     * @throws TelegramSDKException
     */
    public function reply(string $text = ""): int
    {
        $message = $this->api->sendMessage(['chat_id' => $this->chatId, 'text' => $text]);
        return $message->messageId;
    }
}
