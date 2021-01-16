<?php


namespace App\Http\Controllers;


use App\Bots\Telegram\TelegramBot;
use App\Bots\Telegram\TelegramConnector;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TelegramController
{
    public function webhook()
    {
        try {
            $bot = new TelegramBot();
            $bot->run();
        } catch (Exception $e) {
            Log::error($e);
        }
    }


    public function deleteBot(): JsonResponse
    {
        TelegramConnector::deleteChatIdFromUser(Auth::id());
        return response()->json([
            'status' => 'success',
            'message' => 'Бот успешно удален',
        ]);
    }


    public function addBot(Request $request): JsonResponse
    {
        $connector = new TelegramConnector();
        $code = (int)$request->input("tg_bot_reg_code");

        if ($connector->registration($code)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Бот успешно добавлен',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'errors' => $connector->getErrors(),
            ], 400);
        }
    }
}
