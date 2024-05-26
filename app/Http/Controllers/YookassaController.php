<?php

namespace App\Http\Controllers;
use YooKassa\Client;

use Illuminate\Http\Request;

class YookassaController extends Controller
{
    public function sendMoney()
    {
        $client = new Client();
        $client->setAuth('Идентификатор магазина', 'Секретный ключ');
    }
}
