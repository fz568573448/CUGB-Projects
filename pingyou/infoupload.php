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
        if (isset($_POST['id']))
        {
            $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_POST['id']}");
            $a = mysql_fetch_array($data);
        }
        if (!isset($_POST['id'])||!isset($_POST['type'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else if (!isset($_SESSION['department'])&&$a[9]==0) echo '<script type="text/javascript">alert("请先上传照片！"); window.location.href="."</script>';
        else if (!(!isset($_SESSION['department'])&&$_POST['id']==$_SESSION['id']||isset($_SESSION['department'])&&($a[3]==$_SESSION['department']||$_SESSION['department']=='中国地质大学（北京）'))) //不是本人或不是（该院/总）管理员
            echo '<script type="text/javascript">alert("你无权查看或修改！"); window.location.href="."</script>';
        else
        {
            //验证输入是否正确
            $type=$_POST['type'];
            $flag=true;
            
            if (600<=$type&&$type<=800)
            {
                $len=iconv_strlen($_POST['name']);
                if ($len==0||$len>16) $flag=false;
            }
            if ($type==201)
            {
                $len=iconv_strlen($_POST['position']);
                if ($len==0||$len>16) $flag=false;
            }
            if (600<=$type&&$type<=800)
            {
                $len=iconv_strlen($_POST['situation']);
                if ($len==0||$len>100) $flag=false;
            }
            if (100<=$type&&$type<=101||300<=$type&&$type<=305||600<=$type&&$type<=800)
            {
                $len=iconv_strlen($_POST['performance']);
                if ($len==0||$len>500||$len<300) $flag=false;
            }
            if (100<=$type&&$type<=101||300<=$type&&$type<=305||400<=$type&&$type<=501||600<=$type&&$type<=800)
            {
                $len=iconv_strlen($_POST['experience']);
                if ($len==0||$len>300||$len<200) $flag=false;
            }
            if ($flag==false)
            {
                $OUTPUTINFO='';
                if (isset($_POST['name'])) $OUTPUTINFO.=iconv_strlen($_POST['name']) . '，';
                if (isset($_POST['position'])) $OUTPUTINFO.=iconv_strlen($_POST['position']) . '，';
                if (isset($_POST['situation'])) $OUTPUTINFO.=iconv_strlen($_POST['situation']) . '，';
                if (isset($_POST['performance'])) $OUTPUTINFO.=iconv_strlen($_POST['performance']) . '，';
                if (isset($_POST['experience'])) $OUTPUTINFO.=iconv_strlen($_POST['experience']) . '，';
                echo '<script type="text/javascript">alert("字数不符合要求！浏览器端与服务器端的字数验证有些许不同，请对照下面给出的服务器端的字数进行个别字数的增减，一般只相差几个字。\n' . $OUTPUTINFO . '"); window.history.back()</script>';
            }//下面开始处理图片
            else
            {
                $fuck=false;
                if (600<=$type&&$type<=800&&!isset($_SESSION['department']))
                {
                    $fuck=true;
                    if($_FILES['photo']['error']||$_FILES['photosmall']['error'])
                    {
                        if ($_FILES['photo']['error']==1||$_FILES['photo']['error']==2) echo '<script type="text/javascript">alert("第一张照片的大小不符合要求！"); window.history.back()</script>';
                        else if ($_FILES['photo']['error']>=3) echo '<script type="text/javascript">alert("第一张照片上传时遇到错误，请重试！"); window.history.back()</script>';
                        else if ($_FILES['photosmall']['error']==1||$_FILES['photosmall']['error']==2) echo '<script type="text/javascript">alert("第二张照片的大小不符合要求！"); window.history.back()</script>';
                        else if ($_FILES['photosmall']['error']>=3) echo '<script type="text/javascript">alert("第二张照片上传时遇到错误，请重试！"); window.history.back()</script>';
                    }
                    else
                    {
                        if ($_FILES['photo']['size']<81920||$_FILES['photo']['size']>1048576)
                            echo '<script type="text/javascript">alert("第一张照片的大小不符合要求！"); window.history.back()</script>';
                        else if ($_FILES['photosmall']['size']<10240||$_FILES['photosmall']['size']>81920)
                            echo '<script type="text/javascript">alert("第二张照片的大小不符合要求！"); window.history.back()</script>';
                        else if ($_FILES['photo']['type']!="image/jpeg"&&$_FILES['photo']['type']!="image/pjpeg")
                            echo '<script type="text/javascript">alert("第一张照片不是jpg格式！"); window.history.back()</script>';
                        else if ($_FILES['photosmall']['type']!="image/jpeg"&&$_FILES['photosmall']['type']!="image/pjpeg")
                            echo '<script type="text/javascript">alert("第二张照片不是jpg格式！"); window.history.back()</script>';
                        else $fuck=false;
                    }
                }
                if ($fuck==false)
                {
                    $fuck2=false;
                    if (600<=$type&&$type<=800&&!isset($_SESSION['department']))
                    {
                        $fuck2=true;
                        $info1=getimagesize($_FILES['photo']['tmp_name']);
                        $info2=getimagesize($_FILES['photosmall']['tmp_name']);
                        // var_dump($info1);
                        // echo max($info1[0],$info1[1])/min($info1[0],$info1[1]);
                        if($info1==false) echo '<script type="text/javascript">alert("第一张照片不是有效的图片格式或图片已损坏！"); window.history.back()</script>';
                        else if($info2==false) echo '<script type="text/javascript">alert("第二张照片不是有效的图片格式或图片已损坏！"); window.history.back()</script>';
                        else if(min($info2[0],$info2[1])<120) echo '<script type="text/javascript">alert("第二张照片过小！"); window.history.back()</script>';
                        else if($info1[2]!=2) echo '<script type="text/javascript">alert("第一张照片不是jpg格式！请勿以修改扩展名的方式上传非jpg格式的图片！"); window.history.back()</script>';
                        else if($info2[2]!=2) echo '<script type="text/javascript">alert("第二张照片不是jpg格式！请勿以修改扩展名的方式上传非jpg格式的图片！"); window.history.back()</script>';
                        else if(max($info2[0],$info2[1])/min($info2[0],$info2[1])>1.15) echo '<script type="text/javascript">alert("第二张照片离接近于正方形的要求相差过远，长宽比超过了1.15！"); window.history.back()</script>';
                        else $fuck2=false;
                    }
                    if ($fuck2==false)
                    {
                        //上传图片
                        if (600<=$type&&$type<=800&&!isset($_SESSION['department']))
                        {
                            move_uploaded_file($_FILES['photo']['tmp_name'],"./photo/big/{$_POST['id']}_{$_POST['type']}.jpg");
                            move_uploaded_file($_FILES['photosmall']['tmp_name'],"./photo/small/{$_POST['id']}_{$_POST['type']}.jpg");
                        }
                        
                        $data2=mysql_query("SELECT * FROM `info` WHERE `id`={$_POST['id']} AND `type`={$_POST['type']}");
                        if (mysql_num_rows($data2)==0) fz_mysql_query("INSERT INTO `info`(`id`, `type`) VALUES ({$_POST['id']},{$_POST['type']})");
                        //不管有没有，都上传。但是要先检查是否为空。
                        $name=$position=$situation=$performance=$experience='';
                        if (isset($_POST['name'])) $name=$_POST['name'];
                        if (isset($_POST['position'])) $position=$_POST['position'];
                        if (isset($_POST['situation'])) $situation=$_POST['situation'];
                        if (isset($_POST['performance'])) $performance=$_POST['performance'];
                        if (isset($_POST['experience'])) $experience=$_POST['experience'];
                        fz_mysql_query("UPDATE `info` SET `name`='$name',`position`='$position',`situation`='$situation',`performance`='$performance',`experience`='$experience' WHERE `id`={$_POST['id']} AND `type`={$_POST['type']}");
                        $data3=mysql_query("SELECT * FROM `info` WHERE `id`={$_POST['id']} AND `type`={$_POST['type']}");
                        $b = mysql_fetch_array($data3);
                        
                        $urlphoto=$MAILWEBURL."/photo/big/{$_POST['id']}_{$_POST['type']}.jpg";
                        $urlphotosmall=$MAILWEBURL."/photo/small/{$_POST['id']}_{$_POST['type']}.jpg";
                        $IMGHTML='';
                        if (600<=$type&&$type<=800) $IMGHTML="
                            <div>
                                <p><strong>集体照： </strong></p>
                                <p><img src=\"$urlphoto\" alt=\"照片\" /></p>
                                <p><strong>集体照（缩略图）： </strong></p>
                                <p><img src=\"$urlphotosmall\" alt=\"照片（缩略图）\" /></p>
                            </div>
                        ";
                        require 'smtp.php';
                        $subject="中国地质大学（北京）$TITLE"."信息上传通知";
                        $body="
                            <p>你已成功完成<strong>{$AWARD[$type]}</strong>上传，这是你上传的信息：</p>
                            <div>
                                <p>{$b[2]}</p>
                                <p>{$b[3]}</p>
                                <p>{$b[4]}</p>
                                <p>{$b[5]}</p>
                                <p>{$b[6]}</p>
                            </div>
                            $IMGHTML
                            <p><strong>注意：如不是本人操作，则可能是学院或学校在后台修改了你的信息！</strong></p>
                            $MAILBOTTOM";
                        // echo $body;
                        //<p>（这里就只给出内容不给标题了，因为写起来太麻烦了有好多种情况要判断。自动发个邮件给你主要是为了防止上传的信息被你或学校学院删掉之后你自己又没保存，就不知道自己之前传的是什么内容了，所以发个邮件给你备份一下）</p>
                        mailto($a[5],$subject,$body);
                        // echo '<script type="text/javascript">alert("上传成功！"); window.history.back(); </script>';
                        if (isset($_SESSION['department'])) echo '<script type="text/javascript">alert("更新成功！之后请勿重复提交相同的更新！"); window.location.href="./main.php" </script>';
                        else echo '<script type="text/javascript">alert("上传成功！之后请勿重复上传相同的内容！"); window.location.href="./show.php?id='.$_POST['id'].'" </script>';
                    }
                }
            }
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
