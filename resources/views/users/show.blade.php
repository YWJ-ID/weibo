@extends('layouts.default')
@section('title', $user->name)

@section('content')
  <div class="row">
    <div class="offset-md-2 col-md-8">
      <div class="col-md-12">
        <div class="offset-md-2 col-md-8">
          <section class="user_info">
{{--            通过给 @include 方法传参，将用户数据以关联数组的形式传送到 _user_info 局部视图上。--}}
            @include('layouts._user_info', ['user' => $user])
          </section>
        </div>
      </div>
    </div>
  </div>
@stop
