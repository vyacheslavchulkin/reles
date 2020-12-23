<?php


namespace App\Bots\Interfaces;

interface BotSenderInterface
{
    public function reply(string $text): int;
}
