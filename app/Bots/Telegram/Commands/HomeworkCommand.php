<?php


namespace App\Bots\Telegram\Commands;


use Telegram\Bot\Commands\Command;

class HomeworkCommand extends Command
{
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


    private function getHomeworkList(): array
    {
        return [
            1111 => "Физика. Измерить длину экватора.",
            2222 => "Летиратура. Выучит наизусь паэму 'Руслан и Людмила'.",
            3333 => "Математика. Расичтать факториал 1000000.",
            4444 => "Биология. Выучить названия костей человека.",
        ]; // TODO: Заглушка для списка заданий
    }
}
