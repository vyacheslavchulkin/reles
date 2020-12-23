<?php

namespace App\Bots\Telegram\Commands;

use Telegram\Bot\Commands\Command;


class HelpCommand extends Command
{
    protected $name = 'help';
    protected $description = 'Помощь';

    public function handle()
    {
        $commands = $this->telegram->getCommands();
        $text = "Список команд:\n";
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }
        $this->replyWithMessage([
            'text' => $text
        ]);
    }
}
