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
        if (isset($_GET['id']))
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_GET['id']}");
            if ($data==false||mysql_num_rows($data)==0)
            {
                echo '<script type="text/javascript">alert("不存在该学生！"); window.location.href="."</script>';
                exit();
            }
            $a = mysql_fetch_array($data);
        }
        if (!isset($_GET['id'])||!isset($_GET['type'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[9]==0) echo '<script type="text/javascript">alert("请先上传照片！"); window.location.href="."</script>';
        else if (!(!isset($_SESSION['department'])&&$_GET['id']==$_SESSION['id']||isset($_SESSION['department'])&&($a[3]==$_SESSION['department']||$_SESSION['department']=='中国地质大学（北京）'))) //不是本人或不是（该院/总）管理员
            echo '<script type="text/javascript">alert("你无权查看或修改！"); window.location.href="."</script>';
        else
        {
            $data2=mysql_query("SELECT * FROM `info` WHERE `id`={$_GET['id']} AND `type`={$_GET['type']}");
            if ($data&&mysql_num_rows($data2)) $b = mysql_fetch_array($data2);
            if (!isset($b))
            {
                $b=array();
                $b[0]=$b[1]=$b[2]=$b[3]=$b[4]=$b[5]=$b[6]='';
            }
            $type=$_GET['type'];
            
            $ADMINHTML='';
            if (isset($_SESSION['department'])) $ADMINHTML='
                <a href="./adminunlock.php?id=' . $_GET['id'] . '"><button type="button" class="btn btn-warning">点击要求其修改照片或个人资料</button></a>（默认情况下，照片和个人资料一经上传即不可修改，此操作会解锁并会自动向他的邮箱发送一封提示邮件。但是，学号、姓名、性别、学院、专业是从教务系统获取的，不可以被修改。）';
            
            $USERHTML='
            <div style="margin: 20px;">
                <a href="./main.php"><button type="button" class="btn btn-primary">回到信息维护主页</button></a>
            </div>';
            if (!isset($_SESSION['department'])) $USERHTML='
            <div style="margin: 20px;">
                <a href="./main.php"><button type="button" class="btn btn-primary">回到信息上传主页</button></a>
                <a href="./show.php?id=' . $_GET['id'] . '"><button type="button" class="btn btn-success">查看已上传信息</button></a>
            </div>';
            
echo <<<FZHTMLHEADER
        <div style="text-align:center">
            <h1><strong>{$AWARD[$type]}</strong>信息上传与修改</h1>
            $USERHTML
        </div>
        <div>
            <form class="form-group info" action="infoupload.php" method="POST" onsubmit="return formCheck(this)" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{$_GET['id']}" />
                <input type="hidden" name="type" value="{$_GET['type']}" />
FZHTMLHEADER;
            if ($type==200)
echo <<<FZHTML200
                <p>三好学生信息上传不需要额外信息，如需上传请直接点击提交！</p>
FZHTML200;
            if (600<=$type&&$type<=800)
            {
                $TMPHTML='班级名称：（如“10041212班”）';
                if (700<=$type&&$type<=701) $TMPHTML='寝室名称:（如“学16楼418室”）';
                if (800<=$type&&$type<=800) $TMPHTML='党支部名称:（请填写学院+支部名称，如“信息工程学院大学生创新实验室党支部”）';
echo <<<FZHTML1
                <div class="form-group">
                    <label>$TMPHTML</label>
                    <input type="text" class="form-control" name="name" value="{$b[2]}" autofocus="" autocomplete="on" />
                </div>
FZHTML1;
            }
            if ($type==201)
echo <<<FZHTML2
                <div class="form-group">
                    <label>担任职务：</label>
                    <input type="text" class="form-control" name="position" value="{$b[3]}" autofocus="" autocomplete="on" />
                </div>
FZHTML2;
            if (600<=$type&&$type<=800)
            {
                $TMPHTML='班级基本情况：（包括班级名称、所在院系、年级、专业、班级人数、成绩优秀率等，字数不超过100字）';
                if (700<=$type&&$type<=701) $TMPHTML='寝室基本情况:（包括寝室名称、所在院系、年级、寝室人数、成绩优秀率等，字数不超过100字）';
                if (800<=$type&&$type<=800) $TMPHTML='党支部基本情况:（请填写支部成立时间、支部人数、支委人数、理论指导教师姓名、工作覆盖群体，字数不超过100字）';
echo <<<FZHTML3
                <div class="form-group">
                    <label>$TMPHTML</label>
                    <textarea class="form-control" name="situation" autofocus="" autocomplete="on" rows="3">{$b[4]}</textarea>
                </div>
FZHTML3;
            }
            if (100<=$type&&$type<=101||300<=$type&&$type<=305||600<=$type&&$type<=800)
            {
                $TMPHTML='突出表现:（包括曾获奖项、学习情况、主要活动等，字数300-500字，要求文字简练、条理清晰、无错别字和错误标点）';
                if (600<=$type&&$type<=601) $TMPHTML='班级突出表现：（包括班级成绩优秀率、班级曾获奖项、班级制度建设情况、班级成员突出表现等，字数300-500字，要求文字简练、条理清晰、无错别字和错误标点）';
                if (700<=$type&&$type<=701) $TMPHTML='寝室突出表现:（包括寝室成绩优秀率、寝室制度建设情况、寝室成员突出表现等，字数300-500字，要求文字简练、条理清晰、无错别字和错误标点）';
                //说要450字，实际上我没改。因为不好在同一个框里给出不同的字数限制。太坑爹了。做下表面工作好了，实际上还是300-500字。
                if (800<=$type&&$type<=800) $TMPHTML='党支部突出表现:（请概括总结支部在党员教育成效、制度创新、服务先锋作用发挥、与基层支部共建效果、党员示范作用以及获奖等方面的情况，字数450-500字，要求文字简练、条理清晰、无错别字和错误标点）';
echo <<<FZHTML4
                <div class="form-group">
                    <label>$TMPHTML</label>
                    <textarea class="form-control" name="performance" autofocus="" autocomplete="on" rows="12">{$b[5]}</textarea>
                </div>
FZHTML4;
            }
            if (100<=$type&&$type<=101||300<=$type&&$type<=305||400<=$type&&$type<=501||600<=$type&&$type<=800)
            {
                $TMPHTML='心得体会:（包括学习经验或活动经验、感受等，字数200-300字，要求文字简练、条理清晰、无错别字和错误标点）';
                if (400<=$type&&$type<=501) $TMPHTML='获奖感言：（字数200-300字，要求积极向上，文字简练、条理清晰、无错别字和错误标点）';
                if (600<=$type&&$type<=601) $TMPHTML='班级建设经验：（主要内容是怎样建设良好的学风、班风，怎样增加班级凝聚力等，字数200-300字，要求文字简练、条理清晰、无错别字和错误标点）';
                if (700<=$type&&$type<=701) $TMPHTML='寝室建设经验:（主要内容是寝室内怎样建设良好的学风和生活习惯，怎样增加寝室凝聚力等，字数200-300字，要求文字简练、条理清晰、无错别字和错误标点）';
                if (800<=$type&&$type<=800) $TMPHTML='党支部建设经验:（请重点围绕如何取得以上成绩，分条填写经验内容，字数200-300字，要求文字简练、条理清晰、无错别字和错误标点）';
echo <<<FZHTML5
                <div class="form-group">
                    <label>$TMPHTML</label>
                    <textarea class="form-control" name="experience" autofocus="" autocomplete="on" rows="8">{$b[6]}</textarea>
                </div>
FZHTML5;
            }
            if (600<=$type&&$type<=800&&!isset($_SESSION['department']))
            {
echo <<<FZHTML6
                <div class="form-group">
                    <label>集体照上传：（若再次提交则会覆盖原有照片，且提交后需要刷新页面以显示新照片）</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                    <input type="file" name="photo">
                    <p class="help-block">必须为jpg格式，大小在80KB-1MB之间。</p>
                </div>
                <div class="form-group">
                    <label>集体照（缩略图）上传：</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="81920" />
                    <input type="file" name="photosmall">
                    <p class="help-block">必须为jpg格式，大小在10KB-80KB之间。约为160像素*160像素，可略高于160*160，接近正方形。</p>
                </div>
FZHTML6;
            }
echo <<<FZHTMLFOOTER1
                <div style="text-align:center">
                    <button class="btn btn-primary" style="width: 120px;" type="submit" >提交</button>
                </div>
            </form>
                <div style="text-align:center">
                    <a href="./infodelete.php?id={$_GET['id']}&type={$_GET['type']}"><button class="btn btn-danger" style="width: 120px;">删除该项</button></a>
                </div>
            <div class="info">
FZHTMLFOOTER1;
            if (600<=$type&&$type<=800&&$b[0]!='')
echo <<<FZHTMLPHOTO
                <div>
                    <p><strong>集体照： </strong></p>
                    <p><img src="./photo/big/{$_GET['id']}_{$_GET['type']}.jpg" alt="没有上传集体照！" /></p>
                    <p><strong>集体照（缩略图）： </strong></p>
                    <p><img src="./photo/small/{$_GET['id']}_{$_GET['type']}.jpg" alt="没有上传集体照（缩略图）！" /></p>
                </div>
FZHTMLPHOTO;
echo <<<FZHTMLFOOTER2
                <h3>下面是<strong>{$_GET['id']}</strong>的基本信息：</h3>
                $ADMINHTML
                <p>&nbsp;</p>
                <div>
                    <p><strong>学号： </strong>{$a[0]}</p>
                    <p><strong>姓名： </strong>{$a[1]}</p>
                    <p><strong>性别： </strong>{$a[2]}</p>
                    <p><strong>学院： </strong>{$a[3]}</p>
                    <p><strong>专业： </strong>{$a[4]}</p>
                    <p><strong>邮箱： </strong>{$a[5]}</p>
                    <p><strong>手机： </strong>{$a[6]}</p>
                    <p><strong>政治面貌： </strong>{$POLITICAL[$a[10]]}</p>
                </div>
                <div>
                    <p><strong>照片： </strong></p>
                    <p><img src="./photo/big/{$_GET['id']}.jpg" alt="照片" /></p>
                    <p><strong>照片（缩略图）： </strong></p>
                    <p><img src="./photo/small/{$_GET['id']}.jpg" alt="照片（缩略图）" /></p>
                </div>
            </div>
        </div>;
FZHTMLFOOTER2;
        }
    ?>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/placeholder.js"></script>
    <script type="text/javascript">
        function formatCheck(field,str)
        {
            var filename=field.value;
            if (filename==0)
            {
                alert("请选择第"+str+"张照片！");
                return false;
            }
            else
            {
                var mime = filename.toLowerCase().substr(filename.lastIndexOf("."));
                if (mime!='.jpg')
                {
                    alert("第"+str+"张照片不是jpg格式！");
                    return false;
                }
            }
            return true;
        }
        
        function nameCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>16)
            {
                alert("高亮处的填写不符合要求！现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        function positionCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>16)
            {
                alert("高亮处的填写不符合要求！现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        function situationCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>100)
            {
                alert("高亮处的填写不符合要求！现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        function performanceCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>500||len<300)
            {
                alert("高亮处的填写不符合要求！现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        function experienceCheck(field)
        {
            var len=field.value.length;
            if (len==0||len>300||len<200)
            {
                alert("高亮处的填写不符合要求！现在的字数为"+len+"字！");
                return false;
            }
            return true;
        }
        
        function formCheck(thisform)
        {
            if (thisform.name&&nameCheck(thisform.name)==false)
            {
                thisform.name.focus();
                return false;
            }
            else if (thisform.position&&positionCheck(thisform.position)==false)
            {
                thisform.position.focus();
                return false;
            }
            else if (thisform.situation&&situationCheck(thisform.situation)==false)
            {
                thisform.situation.focus();
                return false;
            }
            else if (thisform.performance&&performanceCheck(thisform.performance)==false)
            {
                thisform.performance.focus();
                return false;
            }
            else if (thisform.experience&&experienceCheck(thisform.experience)==false)
            {
                thisform.experience.focus();
                return false;
            }
            else if (thisform.photo&&formatCheck(thisform.photo,"一")==false)
            {
                thisform.photo.focus();
                return false;
            }
            else if (thisform.photosmall&&formatCheck(thisform.photosmall,"二")==false)
            {
                thisform.photosmall.focus();
                return false;
            }
            return true;
        }
    </script>
  </body>
</html>
