<?php

namespace App\Jobs;

use App\Models\HomeworkChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramHomeworkHitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected int $chatId;
    protected string $fileId;
    protected int $homeworkId;
    protected int $userId;
    protected string $message;
    private const TELEGRAM_API_URL = "https://api.telegram.org/file/bot";


    /**
     * Create a new job instance.
     * @param int $chatId
     * @param string $fileId
     * @param int $homeworkId
     * @param int $userId
     * @param string $message
     */
    public function __construct(int $chatId, string $fileId, int $homeworkId, int $userId, ?string $message)
    {
        $this->chatId = $chatId;
        $this->fileId = $fileId;
        $this->message = $message ?? "";
        $this->userId = $userId;
        $this->homeworkId = $homeworkId;
    }


    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $fileUrl = $this->getFilePath($this->fileId);
        $this->saveFile($fileUrl);
    }


    private function getFilePath(string $fileId): ?string
    {
        try {
            $telegram = new Api(config("telegram.bots.mybot.token"));
            $file = $telegram->getFile(["file_id" => $fileId]);
            return self::TELEGRAM_API_URL . config("telegram.bots.mybot.token") . "/" . $file->filePath;
        } catch (TelegramSDKException $e) {
            Log::error($e);
            return null;
        }
    }


    private function saveFile(string $fileUrl): void
    {
        $chat = new HomeworkChat;
        $chat->homework_id = $this->homeworkId;
        $chat->sender_id = $this->userId;
        $chat->message = $this->message;
        $chat->save();
        $chat->addMediaFromUrl($fileUrl)->toMediaCollection('files');
    }
}
