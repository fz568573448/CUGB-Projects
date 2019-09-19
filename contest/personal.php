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
        $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
        $a = mysql_fetch_array($data);
        $coj='';
        if (isset($_COOKIE["username"])) $coj=$_COOKIE["username"];
        if ($a['coj']!='') $coj=$a['coj'];
echo <<<FZHTML
        <div style="text-align:center">
            <h1>个人信息完善</h1>
            <div class="alert alert-warning">
                <p>注意：完善个人信息是为了方便接收比赛相关通知。尤其是邮箱和手机号码一定要填写正确。</p>
                <p>为了保证你填写的邮箱地址有效，提交本页后将会有一封邮件发送至你的邮箱进行验证，必须验证邮箱才能完成报名。</p>
                <p>请勿使用gmail等“你懂的”邮箱，否则邮件将无法发送。</p>
                <p><strong>邮件发送可能需要等待若干秒，若没有找到邮件请检查垃圾箱。</strong></p>
                <p>若你发现你的邮箱填写错误，重新填写本页信息即可，系统将会重新发送邮件。</p>
                <p>完成报名后如果你修改你的相关信息，邮箱也会变成未验证状态，必须再重新验证一次。</p>
            </div>
        </div>
        <div>
            <form class="form-signin" action="sendmail.php" method="POST" onsubmit="return formCheck(this)">
                <div>
                    <p><strong>学号： </strong>{$a[0]}</p>
                    <p><strong>姓名： </strong>{$a[1]}</p>
                    <p><strong>性别： </strong>{$a[2]}</p>
                    <p><strong>学院： </strong>{$a[3]}</p>
                    <p><strong>专业： </strong>{$a[4]}</p>
                </div>
                <div class="form-group">
                    <label>邮箱：</label>
                    <input type="text" class="form-control" placeholder="E-mail" name="email" value="{$a['email']}" autofocus="" autocomplete="on" />
                </div>
                <div class="form-group">
                    <label>手机号码：</label>
                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value="{$a['mobile']}" autocomplete="on" />
                </div>
                <div class="form-group">
                    <label>OJ用户名（网络资格赛请用此账号参赛）：</label>
                    <input type="text" class="form-control" placeholder="OJ Username" name="coj" value="$coj" autocomplete="on" />
                </div>
                <div class="form-group">
                    <label>谈谈自身情况或其他想说的话：</label>
                    <textarea class="form-control" name="situation" autofocus="" autocomplete="on" rows="3">{$a['situation']}</textarea>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" >Submit</button>
            </form>
        </div>
FZHTML;
    ?>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
    <script type="text/javascript">
        function emailCheck(field)
        {
            var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
            var magic = /^([\.a-zA-Z0-9_-])+@gmail\.com$/i;
            if (field.value.length>64||!pattern.test(field.value))
            {
                alert("邮箱地址格式不正确！");
                return false;
            }
            else if (magic.test(field.value))
            {
                alert("请勿使用gmail等“你懂的”邮箱！");
                return false;
            }
            return true;
        }
        function mobileCheck(field)
        {
            var pattern = /^1\d{10}/;
            if (!pattern.test(field.value))
            {
                alert("手机号码格式不正确！");
                return false;
            }
            return true;
        }
        function cojCheck(field)
        {
            var len=field.value.length;
            if (len==0)
            {
                alert("请填写OJ用户名！");
                return false;
            }
            return true;
        }
        function situationCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>200)
            {
                alert("请填写自身情况或其他想说的话，或字数过多，请勿超过200字。现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        
        function formCheck(thisform)
        {
            if (emailCheck(thisform.email)==false)
            {
                thisform.email.focus();
                return false;
            }
            else if (mobileCheck(thisform.mobile)==false)
            {
                thisform.mobile.focus();
                return false;
            }
            else if (cojCheck(thisform.coj)==false)
            {
                thisform.coj.focus();
                return false;
            }
            else if (situationCheck(thisform.situation)==false)
            {
                thisform.situation.focus();
                return false;
            }
            return true;
        }
    </script>
  </body>
</html>
