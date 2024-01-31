<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordController
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
//        1、验证邮箱地址是否正确;
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;

//        2、获取对应用户;
        $user = User::where('email', $email)->first();

//        3、如果不存在;
        if (is_null($user)) {
            session()->flash('danger' , '邮箱未注册');
            return redirect()->back()->withInput();
        }

//        4、生成Token,会在视图emails.reset_link里拼接链接;
        $token = hash_hmac('sha256',Str::random(40),config('app_key'));

//        5、入库，使用 updateOrInsert 来保持 Email 唯一;
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);

//        6、将 Token 链接发送给用户;
        Mail::send('emails.reset_link', compact('token'), function ($message) use ($email) {
            $message->to($email)->subject("忘记密码");
        });

        session()->flash('success' , '密码重置链接已发送至邮箱');
        return redirect()->back();
    }
}
