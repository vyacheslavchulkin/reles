<?php


namespace App\Bots\Telegram;


use App\Bots\Interfaces\BotInterface;
use App\Bots\Telegram\Traits\TelegramBotBase;
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
    use TelegramBotBase;


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
        $this->telegram = new Api(config('telegram.bots.mybot.token'));
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
}
