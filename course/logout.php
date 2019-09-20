<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGB课表抓取</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selection.css" media="all" />
    <script src="js/function.js"></script>
  </head>
  <body>
    <?php
        session_start();
        require_once 'function.php';
        //更新manifest文件
        updateCache();
        //使浏览器刷新一次
        setcookie("reload", "0", time()+360000000);
        
        echo '<script type="text/javascript">refresh();</script>';
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
