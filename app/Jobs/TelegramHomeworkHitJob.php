<?php

namespace App\Jobs;

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
    private const TELEGRAM_API_URL = "https://api.telegram.org/file/bot";


    /**
     * Create a new job instance.
     * @param int $chatId
     * @param string $fileId
     */
    public function __construct(int $chatId, string $fileId, int $homeworkId)
    {
        $this->chatId = $chatId;
        $this->fileId = $fileId;
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
        Log::debug($this->chatId);
        Log::debug($this->homeworkId);
        Log::debug($fileUrl); // TODO заглушка
    }
}
