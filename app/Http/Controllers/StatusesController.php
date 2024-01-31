<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        Auth::User()->statuses()->create([
            'content' => $request['content']
        ]);
//        在用户完成微博的创建之后，需要将其导向至上一次发出请求的页面，即网站主页，因此我们可以使用 back 方法来完成
        session()->flash('success', '微博发布成功');
        return redirect()->back();
    }

//    使用的是『隐性路由模型绑定』功能，Laravel 会自动查找并注入对应 ID 的实例对象 $status，如果找不到就会抛出异常。
    public function destroy(Status $status)
    {
//        做删除授权的检测，不通过会抛出 403 异常。
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除');
        return redirect()->back();
    }

}
