<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
<meta name="description" content="">
<meta name="author" content="wxw">

<title>城院小助手 | csxyxzs</title>

<!-- Bootstrap core CSS -->
<link href="/csxyxzs-master/Public/Css/bootstrap.css" rel="stylesheet" type="text/css">

<!-- Custom styles for this template -->
<link href="/csxyxzs-master/Public/Css/signin.css" rel="stylesheet">

<script type="text/javascript" src="/csxyxzs-master/Public/Js/jquery-1.12.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("button").click(function(){
      var studentno = $("#inputText").val();
      var password = $("#inputPassword").val();
      var openid = $("#inputOpenid").val();
      if(studentno.length != 0 && studentno != "" && password.length != 0 && password != ""){
      $.post("/csxyxzs-master/index.php/Home/Login/doLogin",
        {
          'studentno':studentno,
          'password':password,
          'openid':openid
        },
        function(data,status){
        //alert(data);
            if(data == 'success'){
                $("#success-show").css("display", "");
                $("#p-show").css("display", "none");
                $("#error-show").css("display", "none");
                $("#al-show").css("display", "none");
                $("#school-show").css("display", "none");
            }else if(data == 'error'){
                $("#success-show").css("display", "none");
                $("#p-show").css("display", "none");
                $("#error-show").css("display", "");
                $("#al-show").css("display", "none");
                $("#school-show").css("display", "none");
            }else if(data == "al"){
                $("#success-show").css("display", "none");
                $("#p-show").css("display", "none");
                $("#error-show").css("display", "none");
                $("#al-show").css("display", "");
                $("#school-show").css("display", "none");
            }else if(data == "school"){
                $("#success-show").css("display", "none");
                $("#p-show").css("display", "none");
                $("#error-show").css("display", "none");
                $("#al-show").css("display", "none");
                $("#school-show").css("display", "");
            }
        });
      return false;
      }
});    
});
</script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">

  <!-- <form action="/csxyxzs-master/index.php/Home/Login/doLogin" type="post" class="form-signin" > -->
  <form class="form-signin" >
    <img src="/csxyxzs-master/Public/Image/logo.png" class="img-responsive center-block" alt="大连理工大学城市学院">
    <div class="form-waring" style="visibility:hidden;" id="p-show" >
      <p></p>
    </div>
    <div class="form-waring" style="display: none;" id="error-show" >
      <p>学号或密码错误</p>
    </div>
    <div class="form-waring" style="display: none;" id="success-show" >
      <p>绑定成功，返回使用吧</p>
    </div>
    <div class="form-waring" style="display: none;" id="al-show" >
      <p>您已经绑定成功，返回使用吧</p>
    </div>
    <div class="form-waring" style="display: none;" id="school-show" >
      <p>绑定失败，确定校网是否无法访问，如果可以访问希望可以加入QQ308407868反馈群告诉给我们，我们会为大家尽快处理，谢谢支持。</p>
    </div>
    <input type="hidden" id="inputOpenid" name="openid" value="<?php echo ($openid); ?>"/>
    <label for="inputText" class="sr-only">学号</label>
    <input name="studentno" id="inputText" class="form-control" placeholder="学号" required="" autofocus="" type="text">
    <label for="inputPassword" class="sr-only">密码</label>
    <input name="password" id="inputPassword" class="form-control" placeholder="密码" required="" type="password">
    <p></p>
    <button class="btn btn-lg btn-default btn-block" type="submit">绑定</button>
  </form>

  <div class="p-record">
    <p>城院小助手. ©Copyright 2016 csxyxzs.</p>
  </div>


</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="ie10-viewport-bug-workaround.js"></script>-->
<script type="text/javascript">
(function () {
 'use strict';
 if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
 var msViewportStyle = document.createElement('style')
 msViewportStyle.appendChild(
   document.createTextNode(
     '@-ms-viewport{width:auto!important}'
     )
   )
 document.querySelector('head').appendChild(msViewportStyle)
 }
 })();
</script>

</body>
</html>