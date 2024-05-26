<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SmsService
{
    private function send($phoneNumber, $code)
    {
        $login = env('SMS.RU_API_LOGIN');
        $password = env('SMS.RU_API_PASSWORD');
        $url = env('SMS.RU_API_URL');
        $message = "{$code} - код для входа на сайт it-cafe. Никому не говорите код";

        $data = [
            'login' => $login,
            'psw' => $password,
            'phones' => $phoneNumber,
            'mes' => $message,
            'fmt' => 3
        ];

        $client = new Client(['verify' => false]);
        $client->post($url, [
            'form_params' => $data
        ]);
    }

    public function somfing($phoneNumber, $code): void
    {
        $cacheKey = 'sms_limit_' . $phoneNumber . '_count';
        if (Cache::has($cacheKey)) {
            $smsCount = Cache::get($cacheKey);
            if ($smsCount < 2) {
                $this->send($phoneNumber, $code);
                Cache::increment($cacheKey);
                return;
            }
        } else {
            Cache::put($cacheKey, 1, now()->addMinutes(10));
            $this->send($phoneNumber, $code);
            return;
        }
    }
}

