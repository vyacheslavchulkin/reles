<?php


namespace App\Bots\Telegram;


use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Methods\Update;
use Telegram\Bot\Traits\Http;

class Helpers
{
    use Http, Update;

    public function __construct()
    {
        $this->accessToken = env("TELEGRAM_BOT_TOKEN");
    }


    /**
     * @param string $fileId
     * @return mixed
     * @throws
     * @throws TelegramSDKException
     */
    public function getFilePath(string $fileId): string
    {
        $params = ["file_id" => $fileId,];
        $response = $this->post("getFile", $params)->getDecodedBody();
        return "https://api.telegram.org/file/bot" . env("TELEGRAM_BOT_TOKEN") .
            "/" . $response["result"]["file_path"];
    }


    /**
     * @param string|null $url
     * @return bool
     * @throws TelegramSDKException
     */
    public function setWebhookUrl(?string $url = null): bool
    {
        $url = ($url) ? $url : "https://" . $_SERVER["HTTP_HOST"] .
            route("telegram.api.webhook", [], false);

        return $this->setWebhook(["url" => $url]);
    }
}
