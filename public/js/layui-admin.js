layui.use(['upload','element'], function(){
	var $ = layui.jquery;
	var element = layui.element;
	var upload = layui.upload;


	//头像上传
  	var uploadInst = upload.render({
	  //  elem: '#upheadimg'
	 	// $('#head-img').attr('src', result); //图片链接（base64）
  	});
  
  	$("#upheadimg").click(function(){
  		 $('#head-img').attr('src', result); 
  	})
});