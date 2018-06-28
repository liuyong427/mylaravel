@extends('admin.base')

@section('title', 'LayUi后台管理系统')
 
@section('content')
<div style="padding: 20px; background-color: #F2F2F2;">
  <div class="layui-row layui-col-space15">
     <div class="layui-col-md6">
      <div class="layui-card" >
     		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" >
			  <ul class="layui-tab-title">
			    <li class="layui-this">HTTP 请求</li>
			    <li>用户管理</li>
			    <li>权限分配</li>
			    <li>商品管理</li>
			    <li>订单管理</li>
			  </ul>
			  <div class="layui-tab-content" style="height: 100px;">
			    <div class="layui-tab-item layui-show">
			    	
			    	<div class="layui-form">
					  <table class="layui-table">
					    <colgroup>
					      <col width="20%">
					      <col width="30%">
					      <col width="50%">
					      <col>
					    </colgroup>
					    <thead> 
					      <tr>
					        <th>链接</th>
					        <th>描述</th>
					        <th>代码</th>
					      </tr> 
					    </thead>
					    <tbody>
					      <tr>
					       	  <td><a  href="javascript:void(0)" onclick="check('path',this)">$request->path()</a></td><td>输出域名后面部分</td><td class="code"></td>
					      </tr>
					      <tr> <td><a  href="javascript:void(0)" onclick="check('phpCode',this)" class="m">$request->is('test/*')</a></td><td>判断</td><td class="code">
					    	<pre class="layui-code"  lay-title="" style="display:none;">
					    		$a =1;
					    		echo $a;
					    	</pre>  
					   	</td></tr>
					    </tbody>
					  </table>
					</div>

			    </div>

			    <div class="layui-tab-item">内容2</div>
			    <div class="layui-tab-item">内容3</div>
			    <div class="layui-tab-item">内容4</div>
			    <div class="layui-tab-item">内容5</div>
			  </div>
			</div>   		
   	  </div>
	</div>
	

    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">输入代码 <button class="layui-btn layui-btn-sm" onclick="check('phpCode')">立即提交</button></div>
        <div class="layui-card-body" >
         	<textarea id="phpCode" placeholder="请输入内容" class="layui-textarea" style="height:200px;overflow:auto;"></textarea>
        </div>
      </div>
    </div>
    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">显示结果</div>
        <div class="layui-card-body" id="result" style="height:200px;overflow:auto;">
         	
        </div>
      </div>
    </div>
  </div>
</div> 


@endsection


@section('script')
<script>
var $;
var layer;
layui.use(['layer','jquery','code'], function(){
	layer = layui.layer;
	layui.code({
		about: false,
	});
	$ = layui.$;

	$('.code').mouseover(function(){

		$(this).parent().find('.code').children('pre').show();

	});
	$('.code').mouseout(function(){
	
		$(this).parent().find('.code').children('pre').hide();

	});
	

	
});

function check(method='',thisT='')
{  	
	if(method=='phpCode' && thisT == ''){
		var phpCode = $('#phpCode').val(); 
	}else{
		var phpCode = $(thisT).parent().siblings('.code').children('pre').text();
	
	}
	if(method == ''){
		method = 'wrong';
	}
	$("#result").html('');
	layer.load();   
	var token = "{{ csrf_token() }}";
	
	 $.ajax({ 
        url: "{{ url('/test') }}"+'/'+method, 
        type:"POST",
        data:{'_token':token,'phpCode':phpCode },
        success: function(data){
           $("#result").html(data);
            layer.closeAll('loading');
        },
        error:function(data){
        	layer.msg(data.responseJSON.message);
        	layer.closeAll('loading');
        }
     });

}


</script>
@endsection