@foreach (['danger', 'warning', 'success', 'info'] as $msg)
{{--  用于判断会话中 $msg 键对应的值是否为空，若为空则在页面上不进行显示--}}
  @if(session()->has($msg))
    <div class="flash-message">
      <p class="alert alert-{{ $msg }}">
        {{--  通过 session() 方法获取会话中的 $msg 键对应的值，并将其输出到页面上，这样就可以在页面上显示出提示信息了。--}}
        {{ session()->get($msg) }}
      </p>
    </div>
  @endif
@endforeach
