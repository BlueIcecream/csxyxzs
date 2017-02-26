<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>课表</title>
<link href="/csxyxzs-master/Public/Css/bootstrap.min.css" rel="stylesheet">
<link href="/csxyxzs-master/Public/Css/bootstrap-responsive.min.css" rel="stylesheet">
<style>
#footer {
  text-align: center;
  font-size: small;
}
table pre {
    font-size: small;
    display: block;
    font-family: -moz-fixed;
    white-space: pre;
    margin: 0;
    padding: 5px;
}
</style>
<script>
function load_weeks(){
    var arr="<?php echo ($suth); ?>";
		var output="";
		for(i=1;i<=20;i++){
				output += '<li><a href="?id='+arr+'&&week='+i+'">第' + i + '周</a></li>';
		}
		document.getElementById("weekslist").innerHTML = output;
}
</script>
</head>
<body onload="load_weeks()">
<div class="container">
  <div class="navbar" role="navigation">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="#">课表</a>
        <ul class="nav pull-right">
          <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">周目 <span class="caret"></span></a>
          <ul class="dropdown-menu" id="weekslist">
          </ul>
          </li>
          <li><a href="http://1.csxyxzs.sinaapp.com/page/about.htm">关于</a></li>
        </ul>                    
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-condensed">
      <caption>
        <h1 class="page-header">当前第<?php echo ($week); ?>周</h1></caption>
      <thead>
        <tr>
          <th></th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
          <th>Sun</th>
        </tr>
      </thead>
      <tbody>
      <tr>
        <td>1<br/>/<br/>2</td>
        <td><?php echo ($s0); ?></td>
        <td><?php echo ($s1); ?></td>
        <td><?php echo ($s2); ?></td>
        <td><?php echo ($s3); ?></td>
        <td><?php echo ($s4); ?></td>
        <td><?php echo ($s5); ?></td>
        <td><?php echo ($s6); ?></td>
      </tr>
      <tr>
        <td>3<br/>/<br/>4</td>
        <td><?php echo ($s7); ?></td>
        <td><?php echo ($s8); ?></td>
        <td><?php echo ($s9); ?></td>
        <td><?php echo ($s10); ?></td>
        <td><?php echo ($s11); ?></td>
        <td><?php echo ($s12); ?></td>
        <td><?php echo ($s13); ?></td>
      </tr>
      <tr>
        <td>5<br/>/<br/>6</td>
        <td><?php echo ($s14); ?></td>
        <td><?php echo ($s15); ?></td>
        <td><?php echo ($s16); ?></td>
        <td><?php echo ($s17); ?></td>
        <td><?php echo ($s18); ?></td>
        <td><?php echo ($s19); ?></td>
        <td><?php echo ($s20); ?></td>
      </tr>
      <tr>
        <td>7<br/>/<br/>8</td>
        <td><?php echo ($s21); ?></td>
        <td><?php echo ($s22); ?></td>
        <td><?php echo ($s23); ?></td>
        <td><?php echo ($s24); ?></td>
        <td><?php echo ($s25); ?></td>
        <td><?php echo ($s26); ?></td>
        <td><?php echo ($s27); ?></td>
      </tr>
      <tr>
        <td>9<br/>/<br/>10</td>
        <td><?php echo ($s28); ?></td>
        <td><?php echo ($s29); ?></td>
        <td><?php echo ($s30); ?></td>
        <td><?php echo ($s31); ?></td>
        <td><?php echo ($s32); ?></td>
        <td><?php echo ($s33); ?></td>
        <td><?php echo ($s34); ?></td>
      </tr>
      <tr>
        <td>11<br/>/<br/>12</td>
        <td><?php echo ($s35); ?></td>
        <td><?php echo ($s36); ?></td>
        <td><?php echo ($s37); ?></td>
        <td><?php echo ($s38); ?></td>
        <td><?php echo ($s39); ?></td>
        <td><?php echo ($s40); ?></td>
        <td><?php echo ($s41); ?></td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
    <div id="footer" >
      <p>在寻求真理的长河中，唯有学习，不断地学习，勤奋地学习，有创造性地学习，才能越重山跨峻岭。</p><br/>
      <p>♥ Do have faith in what you're doing.</p>
      <p>Producted by <a href="http://2.cityuit.sinaapp.com">城市学院小助手</a> </p>
    </div>  
</div>
<script src="/csxyxzs-master/Public/Js/jquery-1.12.1.min.js"></script>
<script src="/csxyxzs-master/Public/Js/bootstrap.min.js"></script>
</body>
</html>