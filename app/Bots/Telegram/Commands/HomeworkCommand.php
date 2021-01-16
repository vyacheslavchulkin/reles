<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotBase;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;

class HomeworkCommand extends Command
{
    use TelegramBotBase;

    protected $name = 'hw';
    protected $description = 'Сдать домашнее задание';

    /**
     * @throws TelegramSDKException
     */
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
