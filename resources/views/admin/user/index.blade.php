@extends('admin.base')
@section('title', '用户列表')

@section('content')

<blockquote class="layui-elem-quote">
 <div class="layui-form">

      <a href="{{ url('Admin/User/create') }}" ><button class="layui-btn layui-btn" ><i class="layui-icon">&#xe608;</i> 添加</button></a>
   
   <from id="searchForm">
    <div class="layui-inline">
      <label class="layui-form-label">用户名</label>
      <div class="layui-input-block">
        <input type="text" name="name" id="name" placeholder="请输入" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">邮箱</label>
      <div class="layui-input-block">
        <input type="text" name="email" id="email" placeholder="请输入" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">状态</label>
      <div class="layui-input-block">
        <select name="status" id="status">
          <option value="">选择</option>
          <option value="ON">正常</option>
          <option value="OFF">禁止</option>
        </select>
      </div>
    </div>
    <div class="layui-inline">
      <button class="layui-btn layuiadmin-btn-admin search" data-type="reload">
        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
      </button>
    </div>
   </from>
  </div>
</blockquote>

<table class="layui-table" id="usertable" lay-data="{ url:'{{url('Admin/User/getUserlist')}}', page:true, limit:10, id:'idTest'}" lay-filter="demo">
  <thead>
    <tr>
      <th lay-data="{field:'id',  sort: true}">ID</th>
      <th lay-data="{field:'name'}">用户名</th>
      <th lay-data="{field:'email', sort: true}">邮箱</th>
      <th lay-data="{field:'status', sort: true, templet: '#stattusTpl' }">状态</th>
      <th lay-data="{ align:'center', toolbar: '#barDemo'}">操作</th>
    </tr>
  </thead>
</table>


@endsection
 
@section('script')

<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="password">修改密码</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit" ">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<script type="text/html" id="stattusTpl">
  @verbatim
  {{#  if(d.status === 'ON'){ }}
    <span style="color: #F581B1;">正常</span>
  {{#  } else { }}
    禁止
  {{#  } }}
  @endverbatim
</script>

<script>
layui.use(['table','layer','form'], function(){
  var table = layui.table;
  var layer = layui.layer;
  var form = layui.form;
  var $ = layui.$;
//搜索
var  active = {
    reload: function(){
     name = $("#name").val();
     email = $("#email").val();
     status=  $("#status").val();
      //执行重载
      table.reload('idTest', {
        page: {
          curr: 1 //重新从第 1 页开始
        }
        ,where: {
          key: {
            'name': name,'email':email,'status':status
          }
        }
      });
    }
  };
  $('.search').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });

 //监听工具条
  table.on('tool(demo)', function(obj){
    var data = obj.data;
    var id = data.id;
    var pwdhtml = '<form class="layui-form" id="password-form">@csrf';
        pwdhtml +='<input type="hidden" name="id" value="'+id+'">';
        pwdhtml += '<div class="layui-form-item"><label class="layui-form-label">密码</label>';
        pwdhtml += '<div class="layui-input-inline">';
        pwdhtml += '<input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">';
        pwdhtml += '</div>';
        pwdhtml += '</div>';
        pwdhtml += '<div class="layui-form-item">';
        pwdhtml += '<label class="layui-form-label">重复密码</label>';
        pwdhtml += '<div class="layui-input-inline">';
        pwdhtml += '<input type="password" name="password_confirmation" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">';
        pwdhtml += '</div></div></form>';

    if(obj.event === 'password'){
       layer.open({
        type: 1, 
        title:data.name,
        btn: ['确定', '取消'],
        content: pwdhtml, //这里content是一个普通的String
        btn1: function(index, layero){//index指的弹窗
          var $ = layui.$;
          var postdata = $('#password-form').serialize();
          $.ajax({ 
            url: "{{ url('Admin/User/resetPassword') }}", 
            type:"POST",
            data:postdata,
            success: function(data){
              if(data.code == '0'){
                  layer.msg(data.msg);
                  layer.close(index); //如果设定了yes回调，需进行手工关闭
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
            },
          });
        }
      });
    } else if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        $.ajax({ 
            url: "{{ url('Admin/User/destroy') }}" + '/' +data.id, 
            type:"GET",
            success: function(data){
              if(data.code == '0'){
                  layer.msg(data.msg);
                  table.reload('idTest', {
                    page: {
                      curr: 1 //重新从第 1 页开始
                    }
                  });
                  layer.close(index); //如果设定了yes回调，需进行手工关闭
              }else{
                layer.msg(data.msg);
                return;
              }
            },
            error:function(data){
               var msg = '';
              $.each(data.responseJSON.errors, function (key, value) {
                  msg += value;
                  msg +="<br>";
              });
              layer.msg(msg);
              return;
            },
          });
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.alert('编辑行：<br>'+ JSON.stringify(data));
      window.location.href = "{{ url('Admin/User/edit')}}" + '/' + data.id;
    }
  });
  
 
  
});



</script>
@endsection
