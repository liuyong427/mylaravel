@extends('admin.base')
@section('title', '用户列表')

@section('content')


<blockquote class="layui-elem-quote">
  
  <a href="{{ url('Admin/User/create') }}" ><button class="layui-btn layui-btn-sm" ><i class="layui-icon">&#xe608;</i> 添加</button></a>
</blockquote>
<table class="layui-table" lay-data="{ url:'{{url('Admin/User/getUserlist')}}', page:true, limit:10, id:'idTest'}" lay-filter="demo">
  <thead>
    <tr>
      <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
      <th lay-data="{field:'id',  sort: true, fixed: true}">ID</th>
      <th lay-data="{field:'name'}">用户名</th>
      <th lay-data="{field:'email', sort: true}">邮箱</th>
      <th lay-data="{field:'status', sort: true }">状态</th>
      <th lay-data="{fixed: 'right', align:'center', toolbar: '#barDemo'}">操作</th>
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

<script>
layui.use(['table','layer'], function(){
  var table = layui.table;
  var layer = layui.layer;
  //监听表格复选框选择
  table.on('checkbox(#demo)', function(obj){
    console.log(obj)
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
        btn1: function(index, layero){
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
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.alert('编辑行：<br>'+ JSON.stringify(data));
      window.location.href = "{{ url('Admin/User/edit')}}" + '/' + data.id;
    }
  });
  
  var $ = layui.$, active = {
    getCheckData: function(){ //获取选中数据
      var checkStatus = table.checkStatus('idTest')
      ,data = checkStatus.data;
      layer.alert(JSON.stringify(data));
    }
    ,getCheckLength: function(){ //获取选中数目
      var checkStatus = table.checkStatus('idTest')
      ,data = checkStatus.data;
      layer.msg('选中了：'+ data.length + ' 个');
    }
    ,isAll: function(){ //验证是否全选
      var checkStatus = table.checkStatus('idTest');
      layer.msg(checkStatus.isAll ? '全选': '未全选')
    }
  };
  
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});



</script>
@endsection
