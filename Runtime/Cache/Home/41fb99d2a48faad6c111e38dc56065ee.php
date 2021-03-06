<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>图书馆查询</title>
    <link href="/csxyxzs-master/Public/Css/library.css" rel="stylesheet">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">图书查询结果</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://cityuit.wuxiwei.cn/index.php">关于我们</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="panel panel-default">
            <table class="table">
               <?php if(is_array($book)): $i = 0; $__LIST__ = $book;if( count($__LIST__)==0 ) : echo "没有查询记录" ;else: foreach($__LIST__ as $key=>$zo): $mod = ($i % 2 );++$i;?><tr>
                     <th>书名：<?php echo ($zo["title"]); ?></th>
                   </tr>
                   <tr>
                     <td>作者：<?php echo ($zo["auther"]); ?>
                       <br />出版社：<?php echo ($zo["press"]); ?>
                       <br />出版时间：<?php echo ($zo["time"]); ?>
                       <br />藏书位置：<?php echo ($zo["place"]); ?> <?php echo ($zo["search"]); ?>
                       <br />图书状态：<?php echo ($zo["state"]); ?>
                     </td>
                   </tr><?php endforeach; endif; else: echo "没有查询记录" ;endif; ?>
            </table>
        </div>
        <!--<1!--下面是分页部分--1>-->
        <!--<ul class="pagination">-->
        <!--  <?php if($p == 1 ): ?><li class='disabled'><a href='#'>&laquo;前一页</a> </li>-->
        <!--  <?php else: ?> <li><a href='?p=<?php echo ($p); ?>-1'>&laquo;前一页</a> </li>-->
        <!--<?php endif; ?>-->
        <!--</ul>-->
    </div>
    <div class="container">
        <div class="row">
            <div id="footer" class="span12">
                <p>♥ Do have faith in what you're doing.</p>
                <p>Producted by <a href="/index.php">城市学院小助手</a> </p>
            </div>  
        </div>
    </div>
</body>
</html>