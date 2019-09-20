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
        $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
        $a = mysql_fetch_array($data);
        if (!isset($_FILES['photo'])||!isset($_FILES['photosmall'])) echo '<script type="text/javascript">window.location.href="."</script>';
        else if ($a[9]) echo '<script type="text/javascript">alert("你已上传过照片，已不可修改！"); window.location.href="."</script>';
        else if ($a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else
        {
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
                    echo '<script type="text/javascript">alert("第一张照片不是jpg格式！请勿以修改扩展名的方式上传非jpg格式的图片！"); window.history.back()</script>';
                else if ($_FILES['photosmall']['type']!="image/jpeg"&&$_FILES['photosmall']['type']!="image/pjpeg")
                    echo '<script type="text/javascript">alert("第二张照片不是jpg格式！请勿以修改扩展名的方式上传非jpg格式的图片！"); window.history.back()</script>';
                else
                {
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
                    else
                    {
                        move_uploaded_file($_FILES['photo']['tmp_name'],"./photo/big/{$_SESSION['id']}.jpg");
                        move_uploaded_file($_FILES['photosmall']['tmp_name'],"./photo/small/{$_SESSION['id']}.jpg");
                        fz_mysql_query("UPDATE `user` SET `photo`=1 WHERE `id`={$_SESSION['id']}");
                        
                        $data=mysql_query("SELECT * FROM `user` WHERE `id`={$_SESSION['id']}");
                        $a = mysql_fetch_array($data);
                        require 'smtp.php';
                        $urlphoto=$MAILWEBURL."/photo/big/{$_SESSION['id']}.jpg";
                        $urlphotosmall=$MAILWEBURL."/photo/small/{$_SESSION['id']}.jpg";
                        $subject="中国地质大学（北京）$TITLE"."信息上传通知";
                        $body="
                            <p>你已成功完成个人信息完善和照片上传，这是你上传的信息：</p>
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
                                <p><img src=\"$urlphoto\" alt=\"照片\" /></p>
                                <p><strong>照片（缩略图）： </strong></p>
                                <p><img src=\"$urlphotosmall\" alt=\"照片（缩略图）\" /></p>
                            </div>
                            $MAILBOTTOM";
                        // echo $body;
                        mailto($a[5],$subject,$body);
                        echo '<script type="text/javascript">alert("上传成功！"); window.location.href="."</script>';
                    }
                }
            }
        }
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
