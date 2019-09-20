<?php
    session_start();
    require 'class.php';
    $szxy=new SZXY;
    $captcha=$szxy->getcaptcha();
    $captcha=base64_decode($captcha);
    echo "$captcha";
?>
