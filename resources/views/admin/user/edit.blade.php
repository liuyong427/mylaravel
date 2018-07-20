@extends('admin.base')

@section('title', '编辑用户')

@section('content')
 <form class="layui-form">
  @csrf
  <div class="hidden">
    <input type="hidden" name="id" value="{{ $data->id }}">  
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用户名</label>
    <div class="layui-input-block">
      <input type="text" name="name" required   lay-verify="required" placeholder="请输入用户名" disabled="" autocomplete="off" class="layui-input" value="{{ $data->name }}"> 
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">邮箱</label>
    <div class="layui-input-block">
      <input type="text" name="email" required  lay-verify="required|email"  placeholder="请输入邮箱" autocomplete="off" class="layui-input" value="{{ $data->email }}">
    </div>
  </div>
 <div class="layui-form-item">
  <label class="layui-form-label">状态</label>
  <div class="layui-input-inline">
    <select name="status" lay-filter="aihao">
      <option value="ON" @if ( $data->status == "ON") selected @endif>正常</option>
      <option value="OFF" @if ( $data->status == "OFF") selected @endif>禁止</option>
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
 <label class="layui-form-label">头像</label>
 <div class="layui-input-block">
 <img id="head-img" @if( $data->head_img == '')  src="{{ url('/images/head/no-img.png') }}" @endif>
 <button type="button" class="layui-btn layui-btn-normal" id="upheadimg">选择图片</button>
 </div>  

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
   //console.log(data.field);return false;
    var $ = layui.$;
    var formdata = $('.layui-form').serialize();
    $.ajax({ 
      url: "{{ url('Admin/User/update') }}", 
      type:"POST",
      data:formdata,
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