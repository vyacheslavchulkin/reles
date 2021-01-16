<?php


namespace App\Bots\Telegram\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

trait TelegramBotRegistration
{
    private int $userId = 0;

    private function isRegistered(): bool
    {
        $this->loadUserId();
        return ($this->userId > 0);
    }

    public function loadUserId()
    {
        if ($this->userId == 0) {
            $user = User::where("telegram_chat_id", "=", $this->update->getChat()->id)->first();
            $this->userId = $user->id ?? -1;
        }
    }


    private function generateCode(): int
    {
        $code = rand(11111, 999999);
        Redis::set("tg_reg_" . $code, $this->chatId, "EX", 600);
        return $code;
    }
}
