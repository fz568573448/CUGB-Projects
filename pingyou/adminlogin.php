<?php require 'global.php' ?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $TITLE ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <!-- <a href=".">回首页</a> -->
    <?php
        if (!isset($_POST["no"])) echo '<script type="text/javascript">alert("请输入用户名！"); window.location.href="./admin.php"</script>';
        else
        {
            $id=trim($_POST["no"]);
            $data=mysql_query("SELECT * FROM `admin` WHERE `id`=$id");
            if ($data&&mysql_num_rows($data)) $a = mysql_fetch_array($data);
            if (!isset($a)||!isset($_POST["pw"])||$a[2]!=$_POST["pw"]) echo '<script type="text/javascript">alert("用户名或密码错误！"); window.location.href="./admin.php"</script>';
            else $_SESSION["department"]=$a[1];
            
            echo '<script type="text/javascript">window.location.href="./admin.php"</script>';
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
