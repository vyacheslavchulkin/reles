<?php


namespace App\Bots\Telegram;


use App\Bots\Telegram\Traits\TelegramBotHomeworkDialog;
use App\Bots\Telegram\Traits\TelegramBotRedis;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\Telegram;

class TelegramBotDialog
{
    use Answerable;
    use TelegramBotHomeworkDialog;
    use TelegramBotRedis;
    use Telegram;

    private int $messageId;
    private int $chatId;
    private array $dialogCondition;

    /**
     * HomeWork constructor.
     * @param Update $update
     * @param Api $api
     */
    public function __construct(Update $update, Api $api)
    {
        $this->telegram = $api;
        $this->update = $update;
        $this->messageId = (int)$update->getMessage()->messageId;
        $this->chatId = (int)$update->getChat()->id;
        $this->redis = $redis = Redis::connection();
    }


    public function dialog(bool $newDialog = false): void
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

            default:
                $this->cleanDialogCondition();
        }
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
}
