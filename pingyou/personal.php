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
        if ($a[8]) echo '<script type="text/javascript">alert("你已验证过邮箱，个人信息已不可修改！"); window.location.href="."</script>';
        else
        {
            //用来选中政治面貌，因为不能直接用value填值
            $selected=array();
            for ($i=0;$i<=13;$i++)
                $selected[$i]='';
            if (isset($a[10])) $selected[$a[10]]=' selected="selected"';
            else $selected[0]=' selected="selected"';
echo <<<FZHTML
        <div style="text-align:center">
            <h1>个人信息完善</h1>
            <div class="alert alert-warning">
                <p style="font-weight: bold;">注意：完善个人信息是为了方便学工的老师修改信息时联系你。</p>
                <p style="font-weight: bold;">为了保证你填写的邮箱地址有效，提交本页后将会有一封邮件发送至你的邮箱进行验证，打开邮件的验证链接后才可以进行评优信息上传。</p>
                <p style="font-weight: bold;">请勿使用gmail邮箱，否则邮件将无法发送。</p>
                <p style="font-weight: bold;">邮件发送可能需要等待若干秒，若没有找到邮件请检查垃圾箱。</p>
                <p style="font-weight: bold;">若你发现你的邮箱填写错误，重新填写本页信息即可，系统将会重新发送邮件。</p>
                <p style="font-weight: bold;">一旦验证完成，本页的信息将不可再修改。</p>
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
                    <label>政治面貌：</label>
                    <select name="political" class="form-control">
                        <option value="0"{$selected[0]}>--请选择政治面貌--</option>
                        <option value="1"{$selected[1]}>中国共产党党员</option>
                        <option value="2"{$selected[2]}>中国共产党预备党员</option>
                        <option value="3"{$selected[3]}>中国共产主义青年团团员</option>
                        <option value="4"{$selected[4]}>中国国民党革命委员会会员</option>
                        <option value="5"{$selected[5]}>中国民主同盟盟员</option>
                        <option value="6"{$selected[6]}>中国民主建国会会员</option>
                        <option value="7"{$selected[7]}>中国民主促进会会员</option>
                        <option value="8"{$selected[8]}>中国农工民主党党员</option>
                        <option value="9"{$selected[9]}>中国致公党党员</option>
                        <option value="10"{$selected[10]}>九三学社社员</option>
                        <option value="11"{$selected[11]}>台湾民主自治同盟盟员</option>
                        <option value="12"{$selected[12]}>无党派民主人士</option>
                        <option value="13"{$selected[13]}>群众</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>邮箱：</label>
                    <input type="text" class="form-control" placeholder="E-mail" name="email" value="{$a[5]}" autofocus="" autocomplete="on" />
                </div>
                <div class="form-group">
                    <label>手机号码：</label>
                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value="{$a[6]}" autocomplete="on" />
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" >Submit</button>
            </form>
        </div>
FZHTML;
        }
    ?>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
    <script type="text/javascript">
        function politicalCheck(field)
        {
            if (field.value==0)
            {
                alert("请选择政治面貌！");
                return false;
            }
            return true;
        }
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
                alert("请勿使用gmail邮箱！");
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
        
        function formCheck(thisform)
        {
            if (politicalCheck(thisform.political)==false)
            {
                thisform.political.focus();
                return false;
            }
            else if (emailCheck(thisform.email)==false)
            {
                thisform.email.focus();
                return false;
            }
            else if (mobileCheck(thisform.mobile)==false)
            {
                thisform.mobile.focus();
                return false;
            }
            return true;
        }
    </script>
  </body>
</html>
