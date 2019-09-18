<?php
    session_start();
    require_once 'function.php';
    $course=new cugbCourse;
    $captcha=$course->getcaptcha();
    $captcha=base64_decode($captcha);
    echo "$captcha";
?>