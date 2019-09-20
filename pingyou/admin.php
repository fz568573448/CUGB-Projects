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
            <h1><?php echo $TITLE ?>后台管理</h1>
            <div class="alert alert-info">
                <div>
                    <p>注意：请使用Chrome / Firefox / Safari / IE11 / Microsoft Edge等较新的浏览器来浏览本站。<br />如果你使用双核浏览器（360、搜狗等），请切换到极速模式。</p>
                </div>
            </div>
        </div>
        <div style="text-align:center">
        <?php
        if (!isset($_SESSION['department']))
echo <<< FZHTML
            <form class="form-signin" action="adminlogin.php" method="POST">
            <form class="form-signin" action="adminlogin.php" method="POST">
                <!-- 加上required=""参数后，返回此页面就会清空input中的内容 -->
                <div class="form-group">
                    <!-- <label>用户名：</label> -->
                    <input type="text" class="form-control" placeholder="Username" name="no" value="" autofocus="" autocomplete="on" />
                </div>
                <div class="form-group">
                    <!-- <label>密码：</label> -->
                    <input type="password" class="form-control" placeholder="Password" name="pw" value="" autocomplete="on" />
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
            </form>
FZHTML;
        else
        {
            echo '<div class="alert alert-success" role="alert">';
            echo "<p>你好，<strong>{$_SESSION['department']}</strong>。";
            echo '<a style="margin-left: 20px;" href="./logout.php"><button type="button" class="btn btn-xs btn-danger">退出登录</button></a></p>';
            echo '<p style="margin-bottom: 30px;">请进行评优信息管理！</p><a href="./main.php"><button type="button" class="btn btn-success btn-lg">进入信息管理</button></a>';
            echo '</div>';
        }
        ?>
        </div>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
  </body>
</html>
