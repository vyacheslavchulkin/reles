<?php


namespace App\Bots\Telegram\Traits;


trait TelegramBotHomeworkDialog
{
    protected function homeworkDialog(array  $dialogCondition, bool $newDialog = false): void
    {
        if($this->isRegistered()) {
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
        $text = "Отправте домашнее задание `" . $homeworkList[$dialogCondition["id"]] . "` на проверку.";
        $buttons = [[['text' => "⏪ Список домашних заданий", "callback_data" => "cmd_hw"]]];
        $this->replyWithKeyboard($text, $buttons, true);
    }


    private function resumeHomeworkDialog(array  $dialogCondition): void
    {
        // TODO убрать в отдельный класс
        $homeworkList = $this->getHomeworkList();
        $message = "Домашнее задание `" . $homeworkList[$dialogCondition["id"]] . "` отправлено на проверку.";
        $this->replyWithMessage([
            'text' => $message,
        ]); // TODO Заглушка задание отправлено
        $this->cleanDialogCondition();
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
