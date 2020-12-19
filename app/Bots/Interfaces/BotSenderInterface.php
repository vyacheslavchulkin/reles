<?php


namespace App\Bots\Interfaces;

interface BotSenderInterface
{
    public function __construct(int $chatId);

    public function typing(): void;

    public function sendText(string $text): int;
}
