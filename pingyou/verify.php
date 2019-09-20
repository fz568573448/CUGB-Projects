<?php
    require 'global.php';
    if (!isset($_GET["id"])||!isset($_GET["verification"]))
        echo '<script type="text/javascript">window.location.href="."</script>';
    else
    {
        $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_GET["id"]}");
        $a = mysql_fetch_array($data);
        if ($a[7]==$_GET["verification"])
        {
            fz_mysql_query("UPDATE `user` SET `flag`=1 WHERE `id`={$_GET['id']}");
            echo '<script type="text/javascript">alert("验证成功！"); window.location.href="."</script>';
        }
        else echo '<script type="text/javascript">alert("错误的验证代码！"); window.location.href="."</script>';
    }
 ?>
