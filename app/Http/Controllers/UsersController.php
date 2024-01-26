<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }



    public function show(User $user)
    {
        //将用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
        return view('users.show', compact('user'));
    }

        //    保存用户并且重定向
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();

//        用户模型 User::create() 创建成功后会返回一个用户对象，并包含新注册用户的所有信息。我们将新注册用户的所有信息赋值给变量 $user，并通过路由跳转来进行数据绑定。
        $user = User::created([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
//     『约定优于配置』的体现，此时 $user 是 User 模型对象的实例。route() 方法会自动获取 Model 的主键，也就是数据表 users 的主键 id，以上代码等同于：
//      redirect()->route('users.show', [$user->id]);
        return redirect()->route('users.show', [$user]);
    }
}
