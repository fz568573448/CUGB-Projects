<?php
    session_start();
    $YEAR="2015";
    $PERIOD="九";
    $TITLE="中国地质大学（北京）第" . $PERIOD . "届程序设计竞赛报名页面";
    $MAIL="acmcugb@gmail.com";
    $MAILWEBURL="http://acm.cugb.edu.cn/campus".$YEAR."/reg";
    $MAILBOTTOM="<hr /><p>此邮件由系统自动发出，请勿回复此邮件。有问题请发送邮件至acmcugb@gmail.com或在2015-CUGBACM预备群中反馈！</p>";
    
    $mysql_server_name="localhost";
    $mysql_username="root";
    $mysql_password="test";
    $mysql_database="contest";
    $conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
    mysql_select_db($mysql_database,$conn);
    
    date_default_timezone_set('Asia/Shanghai');
?>
