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
            <h1><?php echo $TITLE ?></h1>
            <div class="alert alert-info">
                <div>
                    <p style="font-weight: bold;">在报名前，请仔细阅读以下信息：</p>
                    <p>1、请使用Chrome / Firefox / Safari / IE11 / Microsoft Edge等较新的浏览器来浏览本站。<br />如果你使用双核浏览器（360、搜狗等），请切换到极速模式。</p>
                    <p>2、报名系统必须从教育在线获取信息，这样可以获得正确姓名、学院、专业信息，防止输入错误。</p>
                    <p>3、此处登录使用的是<a href="http://jwc.cugb.edu.cn/homepage/index.do" target="_blank" style="text-decoration: underline" >教育在线</a>的密码，而不是<a href="http://www.cugb.edu.cn/cugbCms/portal/index.action" target="_blank" style="text-decoration: underline" >信息门户（数字校园）</a>的密码。默认密码是学号，如果你一直密码错误，请尝试使用学号。</p>
                    <p>4、系统只会从教育在线获取你的姓名、性别、学院和专业，不会查看和修改其他任何信息，更不会记录你的密码。</p>
                    <p>5、在报名时遇到问题，请发送邮件至<?php echo $MAIL ?>或在下面的群中反馈。</p>
                    <p>6、15级新生请加入<a href="http://jq.qq.com/?_wv=1027&k=aLO5Yu" target="_blank" style="text-decoration: underline" >2015-CUGBACM预备群</a>（196513291）</p>
                </div>
                <a href="./registered.php"><button type="button" class="btn btn-primary">查看已报名名单</button></a>
            </div>
        </div>
        <div style="text-align:center">
        <?php
        if (!isset($_SESSION['id']))
echo <<< FZHTML
            <form class="form-signin" action="login.php" method="POST">
                <!-- 加上required=""参数后，返回此页面就会清空input中的内容 -->
                <div class="form-group">
                    <!-- <label>学号：</label> -->
                    <input type="text" class="form-control" placeholder="Student No." name="no" value="" autofocus="" autocomplete="on" />
                </div>
                <div class="form-group">
                    <!-- <label>密码：</label> -->
                    <input type="password" class="form-control" placeholder="Password" name="pw" value="" autocomplete="on" />
                </div>
                <div class="form-group">
                    <!-- <label>验证码：</label> -->
                    <input type="text" class="form-control" placeholder="Captcha" name="ca" autocomplete="off" />
                </div>
                <div style="margin:15px"><img src="showcaptcha.php" onclick="this.src='showcaptcha.php'" style="cursor:pointer;" /></div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
            </form>
FZHTML;
        else
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
            $a = mysql_fetch_array($data);
            echo '<div class="alert alert-success" role="alert">';
            echo "<p>你好，<strong>{$a[0]} {$a[1]}</strong>。";
            echo '<a style="margin-left: 20px;" href="./logout.php"><button type="button" class="btn btn-xs btn-danger">退出登录</button></a></p>';
            if ($a['ip']=='') echo '<p style="margin-bottom: 30px;">请完善信息！</p>';
            else if ($a['flag']==0) echo '<p style="margin-bottom: 30px;">请验证邮箱！</p>';
            else echo '<p style="margin-bottom: 30px;">你已完成报名！</p>';
            echo '<a href="./personal.php"><button type="button" class="btn btn-success btn-lg">完善/修改个人信息</button></a></div>';
        }
        ?>
        </div>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
  </body>
</html>
