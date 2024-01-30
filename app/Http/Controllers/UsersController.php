<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

//注册页面
class UsersController extends Controller
{
    public function __construct()
    {
//        通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，意为 —— 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //显示所有用户
    public function index()
    {
        $users = User::paginate(10);
//        $users = User::all();
        return view('users.index', compact('users'));
    }

    //显示创建用户的页面
    public function create()
    {
        return view('users.create');
    }

    //显示用户个人信息的页面
    public function show(User $user)
    {
        //将用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
        return view('users.show', compact('user'));
    }

    //创建用户
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        var_dump($request->name);
        var_dump($request->email);
        var_dump($request->password);

//        用户模型 User::create() 创建成功后会返回一个用户对象，并包含新注册用户的所有信息。我们将新注册用户的所有信息赋值给变量 $user，并通过路由跳转来进行数据绑定。
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
//     『约定优于配置』的体现，此时 $user 是 User 模型对象的实例。route() 方法会自动获取 Model 的主键，也就是数据表 users 的主键 id，以上代码等同于：
//      redirect()->route('users.show', [$user->id]);
        return redirect()->route('users.show', [$user]);
    }

    //用户编辑页面
    public function edit(User $user)
    {
        //现在，使用 id 为 1 的用户登录，当访问 id 为 2 的用户编辑页面 —— weibo.test/users/2/edit ，系统将会拒绝访问。
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //更新用户资料
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功');

        return redirect()->route('users.show', $user->id);
    }

    //管理员删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '用户删除成功!');
        return back();
    }
}
