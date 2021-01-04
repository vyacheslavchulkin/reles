<?php


namespace App\Bots\Telegram\Traits;


trait TelegramBotBase
{
    private function checkCallBackData(): bool
    {
        return ($this->update->detectType() == "callback_query");
    }


    private function replyWithKeyboard(string $text, array $buttons, bool $enableHomeButton = false): void
    {
        if ($enableHomeButton) {
            $buttons[] = [['text' => "⏪ В начало", "callback_data" => "cmd_start"]];
        }

        $keyboard = ['inline_keyboard' => $buttons];
        if ($this->checkCallBackData()) {
            $this->telegram->editMessageText([
                "text" => $text,
                "message_id" => $this->update->callbackQuery->message->messageId,
                "chat_id" => $this->update->callbackQuery->message->chat->id,
                "reply_markup" => json_encode($keyboard),
            ]);
        } else {
            $this->replyWithMessage([
                'text' => $text,
                "reply_markup" => json_encode($keyboard)
            ]);
        }
    }


    private function replyRegError(): void
    {
        $buttons = [[['text' => "Регистрация", "callback_data" => "cmd_reg"]]];
        $text = "Ошибка!\nВы должны зарегистрироваться";
        $this->replyWithKeyboard($text, $buttons, true);
    }


    private function isRegistered(): bool
    {
        return true; // TODO заглушка для проверки авторизаци
    }
}
