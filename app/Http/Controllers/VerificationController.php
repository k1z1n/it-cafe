<?php

namespace App\Http\Controllers;

use App\Models\MobileVerificationToken;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
//    protected SmsService $smsService;
//
//    public function __construct(SmsService $smsService)
//    {
//        $this->smsService = $smsService;
//    }
//
//    public function sendAuthCode(Request $request)
//    {
//        $phone = $request->input('phoneNumber');
//
//        $cuc = Cookie::make('phone_number', $phone, 10);
//        Cookie::queue($cuc);
//        $user = User::updateOrCreate([
//            'phone_number' => $phone,
//        ]);
//        $code = Str::padLeft(rand(0, 9999), 4, '0');
//        MobileVerificationToken::updateOrCreate(
//            [
//                'user_id' => $user->id,
//            ],
//            [
//                'token' => $code,
//                'sent_at' => now(),
//                'expires_at' => now()->addMinutes(10),
//            ]
//        );
//        $this->smsService->somfing($phone, $code);
//
//        return redirect()->route('auth.verify');
//    }
//
//    public function verify(Request $request)
//    {
//        $code = $request->input('verificationCode');
//        $phone = Cookie::get('phone_number');
//
//        $id = User::where('phone_number', $phone)->pluck('id')->first();
//
//        $token = MobileVerificationToken::where('user_id', $id)
//            ->where('token', $code)
//            ->where('expires_at', '>=', now())
//            ->first();
//        if ($token) {
//            $user = User::where('id', $id)->first();
//            auth()->login($user);
//            Cookie::queue(Cookie::forget('phone_number'));
//
//            return redirect()->route('auth.form');
//        }
//
//        return redirect()->back()->with('error', 'Неверный код подтверждения.');
//    }
//
//    public function logout()
//    {
//        auth()->logout();
//        request()->session()->invalidate();
//        request()->session()->regenerateToken();
//        return redirect()->route('index');
//    }
//
//    public function showAuthForm()
//    {
//        return view('send');
//    }
//
//    public function showVerifyForm()
//    {
//        return view('verify');
//    }
}
