<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotHomeworkDialog;
use Telegram\Bot\Commands\Command;

class HomeworkCommand extends Command
{
    use TelegramBotHomeworkDialog;

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
            $keyboard = ['inline_keyboard' => $buttons];

            $this->replyWithMessage([
                'text' => "Список домашних заданий:\n",
                "reply_markup" => json_encode($keyboard)
            ]);
        } else {
            $this->replyWithMessage([
                'text' => "Ошибка! \nВы должны зарегестрироваться"
            ]);
        }
    }


    private function isRegistered(): bool
    {
        return true; // TODO заглушка для проверки авторизаци
    }
}
