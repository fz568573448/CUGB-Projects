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
        if (isset($_GET['id'])&&isset($_GET['type'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else
        {
            if (isset($_GET['id'])&&$_GET['id']==$_SESSION['id'])
            {
                $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_GET['id']}");
                $a = mysql_fetch_array($data);
                $info=mysql_query("SELECT * FROM `info` WHERE `id`={$_GET['id']}");
echo <<<FZHTMLUSER
    <div style="text-align:center">
        <h1><strong>{$_GET['id']}</strong>信息查看</h1>
        <div style="margin: 20px;">
            <a href="./main.php"><button type="button" class="btn btn-primary">回到信息上传主页</button></a>
            <a href="./show.php?id={$_GET['id']}"><button type="button" class="btn btn-success">查看已上传信息</button></a>
        </div>
    </div>
    <table class="table table-hover table-striped info">
FZHTMLUSER;
                while($c=mysql_fetch_array($info))
                {
                    echo "<tr><td>{$a[0]}</td><td>{$a[1]}</td><td>{$a[2]}</td><td>{$a[3]}</td><td>{$a[4]}</td><td>{$AWARD[$c[1]]}</td>
                    <td><a href=\"./info.php?id={$_GET['id']}&type={$c[1]}\"><button type=\"button\" class=\"btn btn-primary\">查看并修改</button></a></td>
                    <td><a href=\"./infodelete.php?id={$_GET['id']}&type={$c[1]}\"><button type=\"button\" class=\"btn btn-danger\">删除</button></a></td>
                    </tr>";
                }
    echo '</table>';
            }
            else if (isset($_GET['type'])&&isset($_SESSION['department']))
            {
                $CONDITION='';
                if ($_SESSION['department']!='中国地质大学（北京）') $CONDITION="AND `user`.department='{$_SESSION['department']}' ";
                $info=mysql_query("SELECT `user`.id, `user`.name, `user`.sex, `user`.department, `user`.major, `info`.type FROM `user`, `info` WHERE `info`.type={$_GET['type']} {$CONDITION}AND `user`.id=`info`.id");
echo <<<FZHTMLADMIN
    <div style="text-align:center">
        <h1><strong>{$AWARD[$_GET['type']]}</strong>信息查看</h1>
        <div style="margin: 20px;">
            <a href="./main.php"><button type="button" class="btn btn-primary">回到信息维护主页</button></a>
        </div>
    </div>
    <table class="table table-hover table-striped info">
FZHTMLADMIN;
                if ($info) while($c=mysql_fetch_array($info))
                {
                    echo "<tr><td>{$c[0]}</td><td>{$c[1]}</td><td>{$c[2]}</td><td>{$c[3]}</td><td>{$c[4]}</td><td>{$AWARD[$c[5]]}</td>
                    <td><a href=\"./info.php?id={$c[0]}&type={$_GET['type']}\"><button type=\"button\" class=\"btn btn-primary\">查看并修改</button></a></td>
                    <td><a href=\"./infodelete.php?id={$c[0]}&type={$_GET['type']}\"><button type=\"button\" class=\"btn btn-danger\">删除</button></a></td>
                    </tr>";
                }
    echo '</table>';
            }
            else echo '<script type="text/javascript">alert("你无权查看或修改！"); window.location.href="."</script>';
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
