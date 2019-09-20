<?php require 'global.php' ?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $TITLE ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
  </head>
  <body>
    <div>
        <div style="text-align:center">
            <h1><?php echo $TITLE ?>已报名名单</h1>
            <a href="."><button type="button" class="btn btn-primary">进入报名页面</button></a>
            <h3>报名成功：</h3>
            <table class="table table-hover table-striped info">
                <tr><td>学号</td><td>姓名</td><td>COJ账号</td><td>网络赛过题数</td></tr>
            <?php
                $data=mysql_query("SELECT * FROM `user` WHERE `flag`=1");
                while($a=mysql_fetch_array($data))
                {
                    $stdid=(string)$a[0];
                    $stdid[8]=$stdid[9]='*';
                    $num=file_get_contents("http://acm.cugb.edu.cn/contest_ac.php?id={$a[7]}&cid=1065");
                    echo "<tr><td>$stdid</td><td>{$a[1]}</td><td><a href=\"http://acm.cugb.edu.cn/userinfo.php?name={$a[7]}\" target=\"_blank\">{$a[7]}</a></td><td>$num</td></tr>";
                }
            ?>
            </table>
            <h3>未完善信息或未验证邮箱：</h3>
            <table class="table table-hover table-striped info">
                <tr><td>学号</td><td>姓名</td><td>COJ账号</td><td>网络赛过题数</td></tr>
            <?php
                $data=mysql_query("SELECT * FROM `user` WHERE `flag`=0");
                while($a=mysql_fetch_array($data))
                {
                    $stdid=(string)$a[0];
                    $stdid[8]=$stdid[9]='*';
                    $num=file_get_contents("http://acm.cugb.edu.cn/contest_ac.php?id={$a[7]}&cid=1065");
                    echo "<tr><td>$stdid</td><td>{$a[1]}</td><td><a href=\"http://acm.cugb.edu.cn/userinfo.php?name={$a[7]}\" target=\"_blank\">{$a[7]}</a></td><td>$num</td></tr>";
                }
            ?>
            </table>
        </div>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
  </body>
</html>
