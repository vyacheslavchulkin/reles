<?php


namespace App\Bots\Telegram\Traits;


use App\Jobs\TelegramHomeworkHitJob;
use App\Models\User;

trait TelegramBotHomework
{
    protected function homeworkDialog(array $dialogCondition, bool $newDialog = false): void
    {
        if ($this->isRegistered()) {
            if ($newDialog) {
                $this->startHomeworkDialog($dialogCondition);
            } else {
                $this->resumeHomeworkDialog($dialogCondition);
            }
        } else {
            $this->replyRegError();
        }
    }


    private function startHomeworkDialog(array $dialogCondition): void
    {
        $homeworkList = $this->getHomeworkList();
        $text = "Отправте домашнее задание <strong>" . $homeworkList[$dialogCondition["id"]] . "</strong> на проверку.";
        $buttons = [[['text' => "⏪ Список домашних заданий", "callback_data" => "cmd_hw"]]];
        $this->replyWithKeyboard($text, $buttons, true);
    }


    private function resumeHomeworkDialog(array $dialogCondition): void
    {
        $message = $this->message;
        switch ($message->detectType()) {
            case "document":
                $this->runHomeworkJob($message->document->fileId, $dialogCondition);
                break;
            case "sticker":
                $this->runHomeworkJob($message->sticker->fileId, $dialogCondition);
                break;
            case "video":
                $this->runHomeworkJob($message->video->fileId, $dialogCondition);
                break;
            case "voice":
                $this->runHomeworkJob($message->voice->fileId, $dialogCondition);
                break;
            case "audio":
                $this->runHomeworkJob($message->audio->fileId, $dialogCondition);
                break;
            case "photo":
                $this->runHomeworkJob($this->getMaxSizePhotoFileId(), $dialogCondition);
                break;
            default:
                $this->reply("Прикрепите файл к сообщению!");
                break;
        }
    }


    private function getHomeworkList(): array
    {
        $homeworkList = [];

        if ($this->isRegistered()) {
            $user = User::find($this->userId);
            $homeworkList = $user->unfinishedHomeworks()
                ->getResults()
                ->mapWithKeys(function ($item) {
                    return [$item->lesson_id => $item->theme];
                })
                ->toArray();
        }
        return $homeworkList;
    }

    private function runHomeworkJob(string $fileId, array $dialogCondition): void
    {
        TelegramHomeworkHitJob::dispatch(
            $this->chatId,
            $fileId,
            $dialogCondition["id"],
            $this->loadUserId(),
            $this->message->caption,
        );

        $homeworkList = $this->getHomeworkList();
        $text = "Домашнее задание <strong>{$homeworkList[$dialogCondition["id"]]}</strong> отправлено на проверку.";
        $buttons = [
            [['text' => "Отправить еще один файл", "callback_data" => "hw_{$dialogCondition["id"]}"]],
            [['text' => "⏪ Список домашних заданий", "callback_data" => "cmd_hw"]]
        ];
        $this->replyWithKeyboard($text, $buttons, true);
        $this->cleanDialogCondition();
    }


    private function getMaxSizePhotoFileId(): string
    {
        $photoList = $this->message->photo;
        $maxFileSize = 0;
        $photoId = "";
        foreach ($photoList->toArray() as $photo) {
            if ($photo["file_size"] > $maxFileSize) {
                $photoId = $photo["file_id"];
                $maxFileSize = $photo["file_size"];
            }
        }
        return $photoId;
    }
}
