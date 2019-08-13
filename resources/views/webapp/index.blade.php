<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{asset('/jquerymobile/jquery.mobile-1.4.5.css')}}">
		<script src="{{asset('/jquerymobile/jquery.min.js')}}"></script>
		<script src="{{asset('/jquerymobile/jquery.mobile-1.4.5.js')}}"></script>
	</head>
<body>
	  <div 	 style="width:60%;margin:10% auto;min-width:250px;">
      <form method="post" action="demoform.php">
        <div>
          <h3>登录信息</h3>
          <label for="usrnm" class="ui-hidden-accessible">用户名:</label>
          <input type="text" name="name" id="name" placeholder="用户名">
          <label for="pswd" class="ui-hidden-accessible">密码:</label>
          <input type="password" name="password" id="password" placeholder="密码">
          <label for="log">保存登录</label>
          <input type="checkbox" name="login" id="log" value="1" data-mini="true">
          <input type="submit" data-inline="true" value="登录">
        </div>
      </form>
    </div>
  </div>
</body>
</html>