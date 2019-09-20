<?php
    if (!isset($_SESSION['id'])&&!isset($_SESSION['department']))
    {
        echo '<script type="text/javascript">alert("请登录！"); window.location.href="."</script>';
        exit();
    }
    else
    {
        $href='.';
        if (isset($_SESSION['department'])) $href='./admin.php';
        echo '<div class="alert alert-success" role="alert" style="padding:0px; margin:0px; text-align:center;"><a style="margin-right: 20px;" href="'.$href.'"><button type="button" class="btn btn-xs btn-primary">回到主页</button></a>你好，<strong>';
        if (isset($_SESSION['department'])) echo $_SESSION['department'];
        else echo $_SESSION['id'] . ' ' . $_SESSION['name'];
        echo '</strong>。<a style="margin-left: 20px;" href="./logout.php"><button type="button" class="btn btn-xs btn-danger">退出登录</button></a></div>';
    }
?>
