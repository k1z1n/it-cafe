<?php

namespace App\Http\Controllers;

use App\Models\MobileVerificationToken;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendAuthCode(Request $request)
    {
        $phone = $request->input('telephone_edit');
        Cookie::queue(Cookie::forget('phone_number'));
        $cuc = Cookie::make('phone_number', $phone, 10);
        Cookie::queue($cuc);
        $user = User::updateOrCreate([
            'phone_number' => $phone,
        ]);
        $code = Str::padLeft(rand(0, 9999), 4, '0');
        MobileVerificationToken::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'token' => $code,
                'sent_at' => now(),
                'expires_at' => now()->addMinutes(10),
            ]
        );
        $phone = '8' . $phone;
        $this->smsService->somfing($phone, $code);
        return response()->json(['success' => true]);
    }

    public function verify(Request $request)
    {
        $code = $request->input('verificationCode');
        $phone = Cookie::get('phone_number');

        $id = User::where('phone_number', $phone)->pluck('id')->first();
        $tokenN = MobileVerificationToken::where('user_id', $id)->first();
        $token = MobileVerificationToken::where('user_id', $id)
            ->where('token', $code)
            ->where('expires_at', '>=', now())
            ->first();
        if ($token) {
            $user = User::where('id', $id)->first();
            auth()->login($user);
            Cookie::queue(Cookie::forget('phone_number'));

            return response()->json(['success' => true]); // Заменил на JSON ответ
        }
        if ($phone != $token) {
            return response()->json(['error' => "$token, $id, $phone, $code,$tokenN"]);
        }
        return response()->json(['error' => 'Неверный код.'], 422); // Заменил на JSON ответ
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('index');
    }

    public function showAuthForm()
    {
        return view('auth.send');
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }
}
