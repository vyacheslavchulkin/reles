<?php


namespace App\Bots\Telegram;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class TelegramConnector
{
    private $errors = [];
    private int $chatId;


    /**
     * @param int $code
     * @return bool
     */
    public function registration(int $code): bool
    {
        $this->chatId = $this->getChatIdByCode($code);

        if ($this->chatId < 0) {
            $this->addError("tg_bot_reg_code", "Введен неверный код");
            return false;
        }

        if (!$this->checkBusyChat()) {
            $this->addError(
                "tg_bot_reg_code",
                "Этот аккаунт в телеграм уже используется другим пользователем! chat_id: {$this->chatId}"
            );
            return false;
        }
        $this->setChatIdToUser();
        return true;
    }


    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    private function getChatIdByCode(int $code): int
    {
        $id = Redis::get("tg_reg_" . $code) ?? -1;
        return (int)$id;
    }


    private function addError(string $id, string $msg): void
    {
        $this->errors[$id] = $msg;
    }


    private function checkBusyChat(): bool
    {
        $count = User::where('telegram_chat_id', '=', $this->chatId)->count();
        return ($count == 0);
    }


    private function setChatIdToUser()
    {
        $user = User::find(Auth::id());
        $user->update(['telegram_chat_id' => $this->chatId]);
        $msg = "{$user->first_name} {$user->middle_name}, добро пожаловать!";
        $bot = new TelegramBotSender($this->chatId);
        $bot->reply($msg);
    }


    public static function deleteChatIdFromUser(int $userId)
    {
        $user = User::find($userId);
        $user->update(['telegram_chat_id' => 0]);
    }
}
