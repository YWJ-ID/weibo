<?php

namespace App\Http\Controllers;

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

}
