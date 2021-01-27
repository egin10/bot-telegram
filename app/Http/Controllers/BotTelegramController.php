<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class BotTelegramController extends Controller
{
    public function setWebhook()
    {
        $response = Telegram::setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);
	    dd($response);
    }

    public function commandHandlerWebHook()
    {
        $updates = Telegram::commandsHandler(true);
        $chat_id = $updates->getChat()->getId();
        $username = $updates->getChat()->getFirstName();

        if(strtolower($updates->getMessage()->getText() === 'halo')) return Telegram::sendMessage([
            'chat_id' => $chat_id, 
            'text' => 'Halo ' . $username 
        ]);

        $phone_number = array_key_exists('contact', $updates['message']) ? $updates['message']['contact']['phone_number'] : null;
        if($phone_number) return Telegram::sendMessage(['chat_id' => $chat_id, 'text' => 'Your phone number is ' . $phone_number]);
    }
}
