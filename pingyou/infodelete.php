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
        if (isset($_GET['id']))
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_GET['id']}");
            $a = mysql_fetch_array($data);
        }
        if (!isset($_GET['id'])||!isset($_GET['type'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[9]==0) echo '<script type="text/javascript">alert("请先上传照片！"); window.location.href="."</script>';
        else if (!(!isset($_SESSION['department'])&&$_GET['id']==$_SESSION['id']||isset($_SESSION['department'])&&($a[3]==$_SESSION['department']||$_SESSION['department']=='中国地质大学（北京）'))) //不是本人或不是（该院/总）管理员
            echo '<script type="text/javascript">alert("你无权查看或修改！"); window.location.href="."</script>';
        else
        {
            $data2=mysql_query("SELECT * FROM `info` WHERE `id`={$_GET['id']} AND `type`={$_GET['type']}");
            if ($data2==false||mysql_num_rows($data2)==0) echo '<script type="text/javascript">alert("不存在该信息！"); window.history.back()</script>';
            else
            {
                fz_mysql_query("DELETE FROM `info` WHERE `id`={$_GET['id']} AND `type`={$_GET['type']}");
                require 'smtp.php';
                $subject="中国地质大学（北京）$TITLE"."信息删除通知";
                $body="
                    <p>你上传的<strong>{$AWARD[$_GET['type']]}</strong>信息已被成功删除！</p>
                    <p><strong>注意：如不是本人操作，则可能是学院或学校在后台修改了你的信息！</strong></p>
                    $MAILBOTTOM";
                // echo $body;
                mailto($a[5],$subject,$body);
                echo '<script type="text/javascript">alert("删除成功！"); window.history.back()</script>';
            }
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
