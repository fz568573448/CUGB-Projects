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
                    <p style="font-weight: bold;">在上传信息前，请仔细阅读以下信息：</p>
                    <p>1、请使用Chrome / Firefox / Safari / IE11 / Microsoft Edge等较新的浏览器来浏览本站。<br />如果你使用双核浏览器（360、搜狗等），请切换到极速模式。</p>
                    <p>2、评优信息上传必须从学工管理获取信息。因为根据以往的经验，会有同学写错自己的学院和专业。</p>
                    <p>3、此处登录使用的是<a href="http://www.cugb.edu.cn/cugbCms/portal/index.action" target="_blank" style="text-decoration: underline" >信息门户（数字校园）</a>的密码，而不是<a href="http://jwc.cugb.edu.cn/homepage/index.do" target="_blank"  style="text-decoration: underline" >教育在线</a>的密码。如果你一直密码错误，请尝试使用身份证号。</p>
                    <p>4、系统只会从信息门户的学工管理获取你的姓名、性别、学院和专业，不会查看和修改其他任何信息，更不会记录你的密码。</p>
                    <p>5、第一次登录需要从学工管理获取信息，因此可能需要等待数秒。</p>
                    <!-- <p>6、评优信息上传完成后会在这个<a href="http://acm.cugb.edu.cn/outstanding/" target="_blank" style="text-decoration: underline" >表彰网站</a>展示。</p> -->
                    <!-- <p>6、评优信息上传完成后会在这个<a href="http://bm.cugb.edu.cn/xgc/ztzl/xjgrxjjtbzztw/20132014xn/" target="_blank" style="text-decoration: underline" >表彰网站</a>展示。</p> -->
                    <p>6、集体奖项请使用一个成员的信息门户账号登录上传。（个人信息的照片请上传本人照片，集体照在填写集体奖项时再上传）</p>
                    <p>7、在评优信息上传时遇到问题，请发送邮件至<?php echo $MAIL ?>反馈。对于评优有问题，请联系学生工作部（处）。</p>
                </div>
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
            if ($a[8]==0) echo '<p style="margin-bottom: 30px;">请完善个人信息或验证邮箱！验证完成后请刷新此页面！</p><a href="./personal.php"><button type="button" class="btn btn-success btn-lg">完善个人信息</button></a>';
            else if ($a[9]==0) echo '<p style="margin-bottom: 30px;">请进行照片上传！</p><a href="./photo.php"><button type="button" class="btn btn-success btn-lg">进入照片上传</button></a>';
            else echo '<p style="margin-bottom: 30px;">请进行评优信息上传！</p><a href="./main.php"><button type="button" class="btn btn-success btn-lg">进入信息上传</button></a>';
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
