<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotInterface;
use App\Bots\Telegram\Traits\TelegramBotHomework;
use App\Bots\Telegram\Traits\TelegramBotRedis;
use App\Bots\Telegram\Traits\TelegramBotRegistration;
use App\Bots\Telegram\Traits\TelegramBotReply;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\Telegram;

class TelegramBot implements BotInterface
{
    use Answerable;
    use Telegram;
    use TelegramBotHomework;
    use TelegramBotRedis;
    use TelegramBotRegistration;
    use TelegramBotReply;


    private Collection $message;
    private string $messageText;
    private int $messageId;
    private int $chatId;
    private array $dialogCondition;


    /**
     * TelegramBot constructor.
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api();
        $this->update = $this->telegram->getWebhookUpdate();
        $this->message = $this->update->getMessage();
        $this->chatId = (int)$this->message->chat->id;
        $this->messageText = trim($this->message->text);
        $this->messageId = (int)$this->message->messageId;
        $this->telegram->addCommands(config("telegram.commands"));
        $this->redis = $redis = Redis::connection();
    }


    /**
     *
     * @throws TelegramSDKException
     */
    public function run(): void
    {
        $this->typing();

        if ($this->isCommand()) {
            $this->telegram->processCommand($this->update);
            $this->cleanDialogCondition();
        } elseif ($this->checkCallBackData()) {
            $this->dialog(true);
        } elseif ($this->checkDialogCondition()) {
            $this->dialog();
        } else {
            $this->telegram->triggerCommand('start', $this->update);
            $this->cleanDialogCondition();
        }
    }


    /**
     * @param bool $newDialog
     */
    private function dialog(bool $newDialog = false): void
    {
        if ($newDialog) {
            $dialogCondition = $this->callbackQueryParser();
            $this->setDialogCondition($dialogCondition);
        } else {
            $dialogCondition = $this->getDialogCondition();
        }

        switch ($dialogCondition["type"]) {

            case "hw":
                $this->homeworkDialog($dialogCondition, $newDialog);
                break;

            case "cmd":
                $this->telegram->triggerCommand($dialogCondition["id"], $this->update);
                $this->cleanDialogCondition();
                break;

            default:
                $this->cleanDialogCondition();
        }
    }


    /**
     * @return bool
     */
    private function checkCallBackData(): bool
    {
        return ($this->update->detectType() == "callback_query");
    }


    /**
     * @return array
     */
    private function callbackQueryParser(): array
    {
        $query = (string)$this->update->callbackQuery->data;
        $explode = explode("_", $query);
        return [
            "type" => $explode[0],
            "id" => (string)$explode[1],
        ];
    }


    /**
     * @return bool
     */
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
