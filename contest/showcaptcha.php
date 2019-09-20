<?php
    session_start();
    require 'class.php';
    $jwc=new JWC;
    $captcha=$jwc->getcaptcha();
    $captcha=base64_decode($captcha);
    echo "$captcha";
?>
