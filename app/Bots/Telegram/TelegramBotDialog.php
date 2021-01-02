<?php


namespace App\Bots\Telegram;


use Redis; // TODO autocomplete
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

class TelegramBotDialog
{
    private Update $update;
    private Api $api;
    private TelegramBotSender $sender;
    private int $messageId;
    private int $chatId;
    const REDIS_PREFIX = "tg_dialog_";

    /**
     * HomeWork constructor.
     * @param Update $update
     * @param Api $api
     */
    public function __construct(Update $update, Api $api)
    {
        $this->update = $update;
        $this->api = $api;
        $this->messageId = (int)$update->getMessage()->messageId;
        $this->chatId = (int)$update->getChat()->id;
        $this->sender = new TelegramBotSender($update->getChat()->id, $api);
    }


    /**
     * @throws TelegramSDKException
     */
    public function newDialog(): void
    {
        $dialogCondition = $this->callbackQueryParser();
        $this->setDialogCondition($dialogCondition);
        switch ($dialogCondition["type"]) {
            case "hw":
                // TODO убрать в отдельный класс
                $homeworkList = $this->getHomeworkList();
                $message = "Отправте домашнее задание `" . $homeworkList[$dialogCondition["id"]] . "` на проверку.";
                $this->sender->reply($message, $this->messageId); // TODO Заглушка нажата кнопка
                break;
            default:
                $this->cleanDialogCondition();
        }
    }


    public function dialog(): void
    {
        $dialogCondition = $this->getDialogCondition();
        switch ($dialogCondition["type"]) {
            case "hw":
                // TODO убрать в отдельный класс
                $homeworkList = $this->getHomeworkList();
                $message = "Домашнее задание `" . $homeworkList[$dialogCondition["id"]] . "` отправлено на проверку.";
                $this->sender->reply($message); // TODO Заглушка задание отправлено
                $this->cleanDialogCondition();
                break;
            default:
                $this->cleanDialogCondition();
        }
    }


    public function checkDialogCondition(): bool
    {
        return !empty(Redis::get(self::REDIS_PREFIX . $this->chatId));
    }


    public function cleanDialogCondition(): void
    {
        Redis::del(self::REDIS_PREFIX . $this->chatId);
    }


    private function setDialogCondition(array $dialogCondition): void
    {
        Redis::set(self::REDIS_PREFIX . $this->chatId, serialize($dialogCondition));
    }


    private function getDialogCondition(): array
    {
        return unserialize(Redis::get(self::REDIS_PREFIX . $this->chatId));
    }

    private function callbackQueryParser(): array
    {
        $query = (string)$this->update->callbackQuery->data;
        $explode = explode("_", $query);
        return [
            "type" => $explode[0],
            "id" => (int)$explode[1],
        ];
    }


    private function getHomeworkList(): array
    {
        // TODO Убрать в отдельный класс
        return [
            1111 => "Физика. Измерить длину экватора.",
            2222 => "Летиратура. Выучит наизусь паэму 'Руслан и Людмила'.",
            3333 => "Математика. Расичтать факториал 1000000.",
            4444 => "Биология. Выучить названия костей человека.",
        ]; // TODO: Заглушка для списка заданий
    }


}
