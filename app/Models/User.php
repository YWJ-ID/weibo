<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * $casts 属性是用来指定数据库字段使用的数据类型，这里指定了 email_verified_at 的类型为时间类型，这个类型跟默认的 created_at 和 updated_at 一致：
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gravatar($size = 100)
    {
//        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=200&d=identicon';
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "https://cdn.v2ex.com/gravatar/$hash?s=$size";
    }
}
