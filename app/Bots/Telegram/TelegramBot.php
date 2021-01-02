<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotInterface;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
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
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->api = new Api();
        $this->update = $this->api->getWebhookUpdate();
        $this->message = $this->update->getMessage();
        $this->chatId = (int)$this->message->chat->id;
        $this->messageText = trim($this->message->text);
        $this->sender = new TelegramBotSender($this->chatId);
        $this->api->addCommands(config("telegram.commands"));
    }


    /**
     *
     * @throws TelegramSDKException
     */
    public function run(): void
    {
        $this->sender->typing();
        $dialog = new TelegramBotDialog($this->update, $this->api);

        if ($this->isCommand()) {
            $this->api->processCommand($this->update);
            $dialog->cleanDialogCondition();
        } elseif ($this->checkCallBackData()) {
            $dialog->newDialog();
        } elseif ($dialog->checkDialogCondition()) {
            $dialog->dialog();
        } else {
            $this->api->triggerCommand('start', $this->update);
            $dialog->cleanDialogCondition();
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
        return ($this->update->detectType() == "callback_query");
    }


}
