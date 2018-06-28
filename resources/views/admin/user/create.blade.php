@extends('admin.base')
 
@section('title', '添加用户')

@section('content')
 <form class="layui-form">
  @csrf
  <div class="layui-form-item">
    <label class="layui-form-label">用户名</label>
    <div class="layui-input-block">
      <input type="text" name="name" required   lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input" value=""> 
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">邮箱</label>
    <div class="layui-input-block">
      <input type="text" name="email" required  lay-verify="required|email"  placeholder="请输入邮箱" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-inline">
      <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">重复密码</label>
    <div class="layui-input-inline">
      <input type="password" name="password_confirmation" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-inline">
      <select name="status" lay-filter="aihao">
        <option value="ON">正常</option>
        <option value="OFF">禁止</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">性别</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男">
      <input type="radio" name="sex" value="女" title="女" checked>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>

</form>
 


@endsection

@section('script')
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(formDemo)', function(data){
   // layer.msg(JSON.stringify(data.field));
    var $ = layui.$;
    $.ajax({ 
      url: "{{ url('Admin/User/store') }}", 
      type:"POST",
      data:data.field,
      success: function(data){
        if(data.code == '0'){
              layer.msg(data.msg);
              window.location.href = "{{ url('Admin/User') }}";
        }else{
          layer.msg(data.msg);
        }
      },
      error:function(data){
        var msg = '';
        $.each(data.responseJSON.errors, function (key, value) {
            msg += value;
            msg +="<br>";
        });
        layer.msg(msg);
      }
    });
    return false;
  });
});
</script>
@endsection