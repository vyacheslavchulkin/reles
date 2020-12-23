<?php

namespace App\Bots\Telegram\Commands;

use Telegram\Bot\Commands\Command;


class StartCommand extends Command
{
    protected $name = 'start';
    protected $description = 'Запуск бота';

    public function handle()
    {
        $commands = $this->telegram->getCommands();
        $text = "Добро пожаловать! \n С чего начнем?\n";
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }
        $this->replyWithMessage([
            'text' => $text
        ]);
    }
}
