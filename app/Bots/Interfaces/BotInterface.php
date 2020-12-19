<?php


namespace App\Bots\Interfaces;


interface BotInterface
{
    public function run(): void;

    public function getFileUrlByFileId(string $fileId): string;
}
