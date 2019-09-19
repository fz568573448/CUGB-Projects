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
    <?php
        require 'class.php';
        $jwc=new JWC;
        if (!isset($_POST["no"])) echo '<script type="text/javascript">alert("请输入用户名！"); window.location.href="."</script>';
        else
        {
            $ret=$jwc->login(trim($_POST["no"]),$_POST["pw"],$_POST["ca"]);
            if ($ret==1) echo '<script type="text/javascript">alert("验证码不正确！"); window.location.href="."</script>';
            else if ($ret==2) echo '<script type="text/javascript">alert("密码错误！"); window.location.href="."</script>';
            else if ($ret==3) echo '<script type="text/javascript">alert("用户名不存在！"); window.location.href="."</script>';
            else
            {
                $id=$_SESSION["id"]=trim($_POST["no"]);
                $data=mysql_query("SELECT * FROM `user` WHERE `id`=$id");
                if ($data&&mysql_num_rows($data)==0)
                {
                    $info=$jwc->loadInfo();
                    mysql_query("INSERT INTO `user`(`id`, `name`, `sex`, `department`, `major`) VALUES ($id,'{$info[0]}','{$info[1]}','{$info[2]}','{$info[3]}')");
                    $_SESSION['name']=$info[0];
                }
                else
                {
                    $a = mysql_fetch_array($data);
                    $_SESSION['name']=$a[1];
                }
                echo '<script type="text/javascript">window.location.href="."</script>';
            }
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
