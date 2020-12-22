<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotInterface;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class TelegramBot implements BotInterface
{
    private Api $api;
    private Collection $message;
    private TelegramBotSender $sender;
    private Update $update;
    private int $chatId;
    private string $messageText;

    /**
     * TelegramBot constructor.
     */
    public function __construct()
    {
        $this->api = new Api();
        $this->update = $this->api->commandsHandler(true);
        $this->message = $this->update->getMessage();
        $this->chatId = (int)$this->message->chat->id;
        $this->messageText = trim($this->message->text);
        $this->sender = new TelegramBotSender($this->chatId);
        $this->api->addCommands(config("telegram.commands"));
    }


    /**
     *
     */
    public function run(): void
    {
        $this->sender->typing();

        if ($this->isCommand()) {
            $this->api->processCommand($this->update);
        } elseif ($this->checkCallBackData()) {
            $this->sender->reply($this->update->callbackQuery->data); // TODO Заглушка нажата кнопка
        } else {
            $this->sender->reply($this->messageText); // TODO заглушка отправлено сообщение в чат
        }
    }


    private function isCommand(): bool
    {
        $text = $this->messageText;
        if (substr($text, 0, 1) == "/") {
            $command = explode(" ", substr($text, 1))[0];
            return array_key_exists(trim($command), $this->api->getCommands());
        }
        return false;
    }


    private function checkCallBackData(): bool
    {
        return !empty($this->update->callbackQuery); // TODO Криво работает
    }
}
