<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotInterface;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBot implements BotInterface
{


    private Api $api;
    private Collection $message;
    private TelegramBotSender $sender;
    private int $chatId;
    private string $messageText;


    /**
     * TelegramBot constructor.
     */
    public function __construct()
    {
        $this->api = new Api();
    }


    /**
     *
     */
    public function run(): void
    {
        $this->update();
        $this->api->commandsHandler(true);
        $this->sender->typing();
        $this->sender->sendText(print_r($this->message, true));
    }


    /**
     * @param string $fileId
     * @return string
     * @throws TelegramSDKException
     */
    public function getFileUrlByFileId(string $fileId): string
    {
        return (new Helpers())->getFilePath($fileId);
    }


    private function update(): void
    {
        $update = $this->api->getWebhookUpdate();
        $this->message = $update->getMessage();
        $this->chatId = (int)$this->message->chat->id;
        $this->messageText = (string)$this->message->text;
        $this->sender = new TelegramBotSender($this->chatId);
    }

}
