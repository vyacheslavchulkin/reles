<?php


namespace App\Bots\Telegram\Commands;


use App\Bots\Telegram\Traits\TelegramBotBase;
use Telegram\Bot\Commands\Command;

class ScheduleCommand extends Command
{
    use TelegramBotBase;

    protected $name = "sch";
    protected $description = "Расписание уроков";

    public function handle()
    {
        if ($this->isRegistered()) {
            $scheduleList = $this->getScheduleList();
            $buttons = [];
            foreach ($scheduleList as $id => $text) {
                $buttons[] = [['text' => $text, "callback_data" => "sch_" . $id]];
            }
            $text = empty($scheduleList) ? "Список домашних заданий пуст" : "Список домашних заданий:\n";
            $this->replyWithKeyboard($text, $buttons, true);
        } else {
            $this->replyRegError();
        }
    }


    private function getScheduleList(): array
    {
        return [
            "1111" => "ПН 23:00 Физкультура",
            "2222" => "ВТ 6:30 Математика",
            "3333" => "СР 8:00 Чаепитие",
            "4444" => "ЧТ 9:00 Музыка",
            "5555" => "ПТ 9:00 Химия",
        ];
    }
}
