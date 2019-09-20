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
        if (!isset($_GET['id'])) echo '<script type="text/javascript">window.location.href="./admin.php"</script>';
        else if (!isset($_SESSION['department'])) echo '<script type="text/javascript">alert("你无权查看或修改！"); window.location.href="./admin.php"</script>';
        else
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_GET['id']}");
            if ($data)
            {
                $a = mysql_fetch_array($data);
                
                fz_mysql_query("UPDATE `user` SET `photo`=0 WHERE `id`={$_GET['id']}");
                require 'smtp.php';
                $subject="中国地质大学（北京）$TITLE"."信息操作通知";
                $body="
                    <p>你已被学校或学院要求修改个人信息或照片，请重新上传！</p>
                    $MAILBOTTOM";
                // echo $body;
                mailto($a[5],$subject,$body);
                echo '<script type="text/javascript">alert("操作成功！"); window.history.back(); </script>';
            }
            else echo '<script type="text/javascript">alert("用户不存在！"); window.location.href="./admin.php"</script>';
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
