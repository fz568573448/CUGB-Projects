<!DOCTYPE html>
<html lang="zh-CN" manifest="cache.appcache">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGB课表抓取</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selection.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/table.css" media="all" />
    <script src="js/function.js"></script>
    <script type="text/javascript">reload();</script>
    <?php
        session_start();
        if (isset($_COOKIE["course"])&&$_COOKIE["course"]=="1") $flag=1;
        else $flag=0;
        if (!$flag) echo '<link rel="stylesheet" type="text/css" href="css/login.css" media="all" />';
    ?>
  </head>
  <body>
    <?php
        if (!$flag) echo '
        <div style="text-align:center">
            <h1>CUGB课表抓取</h1>
            <div class="alert alert-info"><p>课表信息将会存储于本地浏览器中，且只要登录一次，<strong>即使离线也可打开此网页</strong>（需浏览器支持HTML5 manifest功能）。</p><p><strong><span style="color: red">若点击登录或重新抓取后页面不更新，请刷新页面，最多需要刷新两次。</span></strong></p><p>若遇到无法更新缓存的情况，请清空浏览器缓存后重试！</p><p>如果你使用IE，建议使用IE11以上版本</p><p>Please sign in jwc.cugb.edu.cn</p></div>
            <form class="form-signin" action="getcourse.php" method="POST">
                <input type="text" class="form-control" placeholder="Student No." name="no" value="" required="" autofocus="" autocomplete="off" />
                <input type="password" class="form-control" placeholder="Password" name="pw" value="" required="" autocomplete="off" />
                <input type="text" class="form-control" placeholder="Captcha" name="ca" required="" autocomplete="off" />
                <div style="margin:15px"><img src="showcaptcha.php" onclick="this.src=\'showcaptcha.php\'" style="cursor:pointer;" /></div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
            </form>
        </div>';
        else
        {
            //得到当前是第几周
            require_once 'function.php';
            $course=new cugbCourse;
            $nowweek=$course->getWeek();
            //提取学号
            $no=$_COOKIE["no"];
            echo '
                <div class="alert alert-success" role="alert" style="padding:0px; margin:0px; text-align:center;">
                ';
            echo "
                    $no 第
                ";
            echo '
                    <div class="btn-group">
                      <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                ';
            if (isset($_GET["week"]))
            {
                echo "{$_GET['week']}";
                $nowweek=$_GET['week'];
            }
            else echo "$nowweek";
            echo '
                      <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                ';
            echo "
                        <li><a href=\".\">当前周</a></li>
                ";
            echo '
                        <li class="divider"></li>
                ';
            for ($i=1;$i<=20;$i++) echo "<li><a href=\"./?week=$i\">$i</a></li>";
            echo '
                      </ul>
                    </div>
                    周课表　　
                    <a href="./logout.php"><button type="button" class="btn btn-xs btn-danger">重新抓取</button></a>
                </div>
                ';
            echo "
                <script type=\"text/javascript\">var week=$nowweek;</script>
                ";
            echo '<script src="js/createtable.js"></script>';
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
