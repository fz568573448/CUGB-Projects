<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGB空教室查询</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selection.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
  </head>
  <body>
    <div style="text-align:center">
        <h1>CUGB空教室查询</h1>
        <div class="alert alert-info"><p>如果你使用IE，建议使用IE11以上版本</p><p>请登录教育在线以获取空教室信息</p><p style="font-weight: bold;">（可能需要等待数秒的时间进行处理）</p><p style="font-weight: bold;">注意：只统计了本科生的教室占用情况，因为教育在线查不到研究生课表信息</p></div>
        <form class="form-signin" action="show.php" method="POST">
            <input type="text" class="form-control" placeholder="Student No." name="no" value="" required="" autofocus="" autocomplete="off" />
            <input type="password" class="form-control" placeholder="Password" name="pw" value="" required="" autocomplete="off" />
            <input type="text" class="form-control" placeholder="第几周（数字）" name="ww" value="" required="" autocomplete="off" />
            <input type="text" class="form-control" placeholder="周几（数字）" name="wk" value="" required="" autocomplete="off" />
            <input type="text" class="form-control" placeholder="Captcha" name="ca" required="" autocomplete="off" />
            <div style="margin:15px"><img src="showcaptcha.php" onclick="this.src='showcaptcha.php'" style="cursor:pointer;" /></div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
        </form>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
