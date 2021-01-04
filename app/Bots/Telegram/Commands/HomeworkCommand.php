<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotBase;
use App\Bots\Telegram\Traits\TelegramBotHomeworkDialog;
use Telegram\Bot\Commands\Command;

class HomeworkCommand extends Command
{
    use TelegramBotHomeworkDialog;
    use TelegramBotBase;

    protected $name = 'hw';
    protected $description = 'Сдать домашнее задание';

    public function handle()
    {
        if ($this->isRegistered()) {
            $homeworkList = $this->getHomeworkList();
            $buttons = [];
            foreach ($homeworkList as $id => $text) {
                $buttons[] = [['text' => $text, "callback_data" => "hw_" . $id]];
            }
            $text = empty($homeworkList) ? "Список домашних заданий пуст" : "Список домашних заданий:\n";
            $this->replyWithKeyboard($text, $buttons, true);
        } else {
            $this->replyRegError();
        }
    }
}
