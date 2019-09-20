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
    <div>
    <?php
        require 'header.php';
        if (isset($_SESSION['id']))
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
            $a = mysql_fetch_array($data);
        }
        if (!isset($_SESSION['id'])&&!isset($_SESSION['department'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[9]==0) echo '<script type="text/javascript">alert("请先上传照片！"); window.location.href="."</script>';
        else
        {
            //为了重用代码
            $USERHTML='
            <div style="margin: 20px;">
                <a href="./main.php"><button type="button" class="btn btn-primary">回到信息维护主页</button></a>
            </div>';
            if (!isset($_SESSION['department'])) $USERHTML='
            <div style="margin: 20px;">
                <a href="./main.php"><button type="button" class="btn btn-primary">回到信息上传主页</button></a>
                <a href="./show.php?id=' . $_SESSION['id'] . '"><button type="button" class="btn btn-success">查看已上传信息</button></a>
            </div>';
            $idGET='';
            if (!isset($_SESSION['department'])) $idGET='id='.$_SESSION['id'].'&';
            $page='./show.php';
            if (!isset($_SESSION['department'])) $page='./info.php';
            $h1='信息维护';
            if (!isset($_SESSION['department'])) $h1='信息上传';
echo <<<FZHTML
        <div style="text-align:center">
            <h1>$h1</h1>
            $USERHTML
        </div>
        <div class="dropdown" style="margin: 0 auto; max-width: 160px;">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            -----请选择奖项-----
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <!-- <li class="dropdown-header">十佳</li> -->
                <li><a href="$page?{$idGET}type=100">十佳本科生</a></li>
                <li><a href="$page?{$idGET}type=101">十佳研究生</a></li>
                <!-- 坑爹啊还要让我改顺序，我编号都按顺序标号的，强迫症不能忍啊！ -->
                <li role="separator" class="divider"></li>
                <li><a href="$page?{$idGET}type=500">自强之星</a></li>
                <li><a href="$page?{$idGET}type=501">优秀学生党支部书记</a></li>
                <li role="separator" class="divider"></li>
                <!-- <li class="dropdown-header">三好优干</li> -->
                <li><a href="$page?{$idGET}type=200">三好学生</a></li>
                <li><a href="$page?{$idGET}type=201">优秀学生干部</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">各类标兵</li>
                <li><a href="$page?{$idGET}type=300">学风标兵</a></li>
                <li><a href="$page?{$idGET}type=301">文艺标兵</a></li>
                <li><a href="$page?{$idGET}type=302">体育标兵</a></li>
                <li><a href="$page?{$idGET}type=303">公益标兵</a></li>
                <li><a href="$page?{$idGET}type=304">社会实践标兵</a></li>
                <li><a href="$page?{$idGET}type=305">科技创新标兵</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">各类奖学金</li>
                <li><a href="$page?{$idGET}type=400">本科生国家奖学金</a></li>
                <li><a href="$page?{$idGET}type=401">硕士研究生国家奖学金</a></li>
                <li><a href="$page?{$idGET}type=419">博士研究生国家奖学金</a></li>
                <li><a href="$page?{$idGET}type=402">国家励志奖学金</a></li>
                <li><a href="$page?{$idGET}type=403">曾宪梓奖学金</a></li>
                <li><a href="$page?{$idGET}type=404">中国石油奖学金</a></li>
                <!-- <li><a href="$page?{$idGET}type=405">中国石化英才奖学金</a></li> -->
                <li><a href="$page?{$idGET}type=406">杨起奖学金</a></li>
                <li><a href="$page?{$idGET}type=407">杨遵仪奖学金</a></li>
                <li><a href="$page?{$idGET}type=408">郝诒纯奖学金</a></li>
                <li><a href="$page?{$idGET}type=409">冯景兰奖学金</a></li>
                <li><a href="$page?{$idGET}type=410">地球化学人才奖学金</a></li>
                <li><a href="$page?{$idGET}type=411">翟裕生奖学金</a></li>
                <li><a href="$page?{$idGET}type=412">赵鹏大奖学金</a></li>
                <li><a href="$page?{$idGET}type=413">希尔威矿业奖学金</a></li>
                <!-- <li><a href="$page?{$idGET}type=414">航勘院地质奖学金</a></li> -->
                <!-- <li><a href="$page?{$idGET}type=415">中国科学院奖学金</a></li> -->
                <!-- <li><a href="$page?{$idGET}type=416">龙润奖学金</a></li> -->
                <li><a href="$page?{$idGET}type=417">SPE奖学金</a></li>
                <li><a href="$page?{$idGET}type=418">刘光文奖学金</a></li>
                <!--  给博士研究生国家奖学金占位419以提示 -->
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">集体奖项</li>
                <li><a href="$page?{$idGET}type=601">十佳班集体</a></li>
                <li><a href="$page?{$idGET}type=600">优秀班集体</a></li>
                <li><a href="$page?{$idGET}type=701">十佳学生宿舍</a></li>
                <li><a href="$page?{$idGET}type=700">优秀学生宿舍</a></li>
                <li><a href="$page?{$idGET}type=800">先锋党支部</a></li>
            </ul>
        </div>
FZHTML;
        }
    ?>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
  </body>
</html>
