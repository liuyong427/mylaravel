<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}">
  <link rel="stylesheet" href="{{asset('/css/admin.css')}}">
  @include('admin.script')
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
 @include('admin.header')

 @include('admin.left')
  
  
  <div class="layui-body" >
    <!-- 内容主体区域 --> 
    <div style="padding:20px;">
    <fieldset class="layui-elem-field layui-field-title">
 		 <legend>@yield('title')</legend>
	</fieldset>
    @yield('content')
  	</div>
  </div> 
  
 @include('admin.footer')
</div>

</body>
 @yield('script')
</html>