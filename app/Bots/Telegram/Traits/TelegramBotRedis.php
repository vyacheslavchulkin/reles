<?php


namespace App\Bots\Telegram\Traits;


use Illuminate\Redis\Connections\Connection;

trait TelegramBotRedis
{
    private Connection $redis;
    private string $prefix= "tg_dialog_";


    public function checkDialogCondition(): bool
    {
        return !empty($this->redis->get($this->prefix . $this->chatId));
    }


    public function cleanDialogCondition(): void
    {
        $this->redis->command("DEL" , [$this->prefix . $this->chatId]);
    }


    private function setDialogCondition(array $dialogCondition): void
    {
        $this->redis->set($this->prefix . $this->chatId, serialize($dialogCondition));
    }


    private function getDialogCondition(): array
    {
        return unserialize($this->redis->get($this->prefix . $this->chatId));
    }
}
