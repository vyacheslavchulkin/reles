<?php


namespace App\Bots\Telegram\Traits;


use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\Telegram;

trait TelegramBotReply
{
    use Telegram;

    /**
     * @throws TelegramSDKException
     */
    public function typing(): void
    {
        $this->telegram->sendChatAction(["chat_id" => $this->chatId, "action" => "typing"]);
    }


    /**
     * @param string $text
     * @param array $buttons
     * @param bool $enableHomeButton
     * @throws TelegramSDKException
     */
    public function replyWithKeyboard(string $text, array $buttons, bool $enableHomeButton = false): void
    {
        if ($enableHomeButton) {
            $buttons[] = [['text' => "⏪ В начало", "callback_data" => "cmd_start"]];
        }

        $keyboard = ['inline_keyboard' => $buttons];
        $this->replyWithMessage([
            'text' => $text,
            "reply_markup" => json_encode($keyboard),
            "parse_mode" => "html",
        ]);

        if ($this->checkCallBackData()) {
            $this->telegram->deleteMessage([
                "message_id" => $this->update->callbackQuery->message->messageId,
                "chat_id" => $this->update->callbackQuery->message->chat->id,
            ]);
        }
    }


    /**
     * @throws TelegramSDKException
     */
    public function replyRegError(): void
    {
        $buttons = [[['text' => "Регистрация", "callback_data" => "cmd_reg"]]];
        $text = "Ошибка!\nВы должны зарегистрироваться";
        $this->replyWithKeyboard($text, $buttons, true);
    }


    /**
     * @param string $text
     * @param int|null $messageId
     * @return int
     * @throws TelegramSDKException
     */
    public function reply(string $text = "", ?int $messageId = null): int
    {
        $params = [];
        $params["chat_id"] = $this->chatId;
        $params["text"] = $text;
        if ($messageId) {
            $params["message_id"] = $messageId;
            $message = $this->telegram->editMessageText($params);
        } else {
            $message = $this->telegram->sendMessage($params);
        }
        return $message->messageId;
    }

}
