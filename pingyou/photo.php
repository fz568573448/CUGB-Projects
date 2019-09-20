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
        if ($a[9]) echo '<script type="text/javascript">alert("你已上传过照片，已不可修改！"); window.location.href="."</script>';
        else if ($a[8]==0) echo '<script type="text/javascript">alert("请先验证邮箱！"); window.location.href="."</script>';
        else
        {
echo <<<FZHTML
        <div style="text-align:center">
            <h1>生活照上传</h1>
            <div class="alert alert-warning">
                <p style="font-weight: bold;">生活照将用于在评优表彰网站展示。</p>
                <p style="font-weight: bold;">要求：所有照片必须为jpg格式，照片要求在80KB-1MB之间，缩略图照片要求在10KB-80KB之间。</p>
                <p style="font-weight: bold;">缩略图必须是正方形或非常接近于正方形，否则可能会导致图片变形。</p>
                <p style="font-weight: bold;">缩略图的大小约为160像素*160像素，可以略高于这一数值但是最好不要低于，否则可能导致模糊。</p>
                <p style="font-weight: bold;">如果实在不会弄缩略图，可以把照片放到QQ里，双击打开，滚轮缩小然后QQ截图即可。截图时会显示图片像素信息。</p>
                <p style="font-weight: bold;">一旦上传完成，照片将不可再修改。</p>
            </div>
        </div>
        <div>
            <form class="form-signin" action="photoupload.php" method="POST" onsubmit="return formCheck(this)" enctype="multipart/form-data">
                <div class="form-group">
                    <label>照片上传：</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                    <input type="file" name="photo">
                    <p class="help-block">必须为jpg格式，大小在80KB-1MB之间。</p>
                </div>
                <div class="form-group">
                    <label>照片（缩略图）上传：</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="81920" />
                    <input type="file" name="photosmall">
                    <p class="help-block">必须为jpg格式，大小在10KB-80KB之间。约为160像素*160像素，可略高于160*160，接近正方形。</p>
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
        //写了半天，依然无法实现功能，也解决不了浏览器兼容性问题。干脆不写了，直接在后端验证。。。
        /*
        var err,width,height,size;
        function getphotoinfo(field)
        {
            err=0,width=0,height=0,size=0;
            var f = field.files[0];
            var reader = new FileReader();
            reader.onload = function (e)
            {
                var data = e.target.result;
                //加载图片获取图片真实宽度和高度
                var img = new Image();
                img.onload=function()
                {
                    width = img.width;
                    height = img.height;
                    size = f.size;
                    // alert(size);
                };
                img.onerror=function(){err=1;}
                img.src= data;
            };
            reader.readAsDataURL(f);
        }
        function photoinfoCheck1(field)
        {
            getphotoinfo(field);
            if (err)
            {
                alert("第一张图片格式不正确或者图片已损坏！");
                return false;
            }
            else if (size<81920||size>1048576)
            {
                alert(width);
                alert("第一张图片的大小不符合要求！");
                return false;
            }
            return true;
        }
        function photoinfoCheck2(field)
        {
            getphotoinfo(field);
            if (err)
            {
                alert("第二张图片格式不正确或者图片已损坏！");
                return false;
            }
            else if (size<10240||size>81920)
            {
                alert("第二张图片的大小不符合要求！");
                return false;
            }
            else if (Math.max(width,height)/Math.min(width,height)>1.15)
            {
                alert("第二张图片不符合非常接近于正方形的要求！");
                return false;
            }
            return true;
        }*/
        
        function formCheck(thisform)
        {
            if (formatCheck(thisform.photo,"一")==false)
            {
                thisform.photo.focus();
                return false;
            }
            else if (formatCheck(thisform.photosmall,"二")==false)
            {
                thisform.photosmall.focus();
                return false;
            }/*
            else if (photoinfoCheck1(thisform.photo)==false)
            {
                thisform.photo.focus();
                return false;
            }
            else if (photoinfoCheck2(thisform.photosmall)==false)
            {
                thisform.photosmall.focus();
                return false;
            }*/
            return true;
        }
    </script>
  </body>
</html>
