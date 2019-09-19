<?php
    date_default_timezone_set('Asia/Shanghai');
    $conn=new mysqli("localhost", "root", "test", "rating");
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGBACM Rating</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body style="text-align:center">
    <h1>CUGBACM Codeforces & Bestcoder Rating</h1>
    <div class="alert alert-info"><p>每日凌晨4:00更新</p></div>
    <div class="main">
        <div>
            <a href="http://www.codeforces.com/" target="_blank"><img style="margin-right: 100px;" src="img/codeforces.png" alt="Codeforces" /></a>
            <a href="http://bestcoder.hdu.edu.cn/" target="_blank"><img src="img/bestcoder.png" alt="Bestcoder" /></a>
        </div>
        <table class="table table-hover table-striped info">
        <tr><td>Name</td><td>ID</td><td>Rating</td></tr>
        <?php
            $cf=$conn->query("SELECT * FROM `info` ORDER BY `cf` DESC")->fetch_all();
            $cnt=count($cf);
            for ($i=0;$i<$cnt;$i++)
            {
                if (!isset($cf[$i][2]))
                {
                    $cf[$i][2]='---';
                    $cf[$i][3]='none';
                }
                echo "<tr><td>{$cf[$i][0]}</td><td><a class=\"{$cf[$i][3]}\" href=\"http://www.codeforces.com/profile/{$cf[$i][1]}\" target=\"_blank\">{$cf[$i][1]}</a></td><td class=\"{$cf[$i][3]}\">{$cf[$i][2]}</td></tr>";
            }
        ?>
        </table>
        <table class="table table-hover table-striped info">
        <tr><td>Name</td><td>ID</td><td>Rating</td></tr>
        <?php
            $bc=$conn->query("SELECT * FROM `info` ORDER BY `bc` DESC")->fetch_all();
            $cnt=count($bc);
            for ($i=0;$i<$cnt;$i++)
            {
                if (!isset($cf[$i][6]))
                {
                    $bc[$i][5]='---';
                    $bc[$i][6]='none';
                }
                echo "<tr><td>{$bc[$i][0]}</td><td><a class=\"{$bc[$i][6]}\" href=\"http://bestcoder.hdu.edu.cn/rating.php?user={$bc[$i][4]}\" target=\"_blank\">{$bc[$i][4]}</a></td><td class=\"{$bc[$i][6]}\">{$bc[$i][5]}</td></tr>";
            }
        ?>
        </table>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
