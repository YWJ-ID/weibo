{{--为局部视图增加前缀下划线是『约定俗成』的做法--}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container ">
    <a class="navbar-brand" href="{{ route('home') }}">Weibo App</a>
    <ul class="navbar-nav justify-content-end">
{{--      //Laravel 提供了 Auth::check() 方法用于判断当前用户是否已登录，已登录返回 true，未登录返回 false--}}
      @if (Auth::check())
        <li class="nav-item"><a class="nav-link" href="#">用户列表</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个人中心</a>
            <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">编辑资料</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
{{--              当用户退出时，实际上相当于删除了用户登录会话的资源，因此这里的退出操作需要使用 DELETE --}}
{{--              请求来发送给服务器。由于浏览器不支持发送 DELETE 请求，因此我们需要使用一个隐藏域来伪--}}
{{--              造 DELETE 请求--}}
                {{ method_field('DELETE') }}
{{--                上面代码等于<input type="hidden" name="_method" value="DELETE">--}}
                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
            </a>
          </div>
        </li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">帮助</a></li>
        <li class="nav-item" ><a class="nav-link" href="{{ route('login') }}">登录</a></li>
      @endif
    </ul>
  </div>
</nav>
