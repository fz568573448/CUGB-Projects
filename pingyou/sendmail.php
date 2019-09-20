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
    <?php
        require 'header.php';
        $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
        $a = mysql_fetch_array($data);
        if (!isset($_POST["email"])||!isset($_POST["mobile"]))
            echo '<script type="text/javascript">window.location.href="."</script>';
        else if ($a[8])
            echo '<script type="text/javascript">alert("你已验证过邮箱，个人信息已不可修改！"); window.location.href="."</script>';
        else
        {
            if ($_POST["political"]==0)
                echo '<script type="text/javascript">alert("请选择政治面貌！"); window.history.back()</script>';
            else if (strlen($_POST["email"])>64||!preg_match("/^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/", $_POST["email"]))
                echo '<script type="text/javascript">alert("邮箱地址格式不正确！"); window.history.back()</script>';
            else if (preg_match("/^([\.a-zA-Z0-9_-])+@gmail\.com$/i", $_POST["email"]))
                echo '<script type="text/javascript">alert("请勿使用gmail邮箱！"); window.history.back()</script>';
            else if (!preg_match("/^1\d{10}/", $_POST["mobile"]))
                echo '<script type="text/javascript">alert("手机号码格式不正确！"); window.history.back()</script>';
            else
            {
                $verification="";
                for ($i=0;$i<16;$i++)
                    $verification.=chr(rand(0, 25)+ord('a'));
                // echo $verification;
                fz_mysql_query("UPDATE `user` SET `email`='{$_POST["email"]}',`mobile`={$_POST["mobile"]},`verification`='$verification',`political`={$_POST["political"]} WHERE `id`={$_SESSION['id']}");
                require 'smtp.php';
                $url=$MAILWEBURL."/verify.php?id={$_SESSION['id']}&verification=$verification";
                $subject="中国地质大学（北京）$TITLE"."邮箱验证";
                $body="<p>你的验证链接为：<br /><a href=\"$url\" target=\"_blank\">$url</a></p><p>验证后方可进行评优信息上传。$MAILBOTTOM</p>";
                // echo $body;
                mailto($_POST["email"],$subject,$body);
                echo '<script type="text/javascript">alert("一封邮件已发送至你的邮箱，验证后方可进行评优信息上传。若没有找到邮件，请检查垃圾箱。"); window.location.href="."</script>';
            }
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
