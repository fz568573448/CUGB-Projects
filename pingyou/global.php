<?php
    session_start();
    $YEAR=2015;
    $TITLE=$YEAR . "年评优信息上传系统";
    $MAIL="xxx@xxx.com";
    $MAILWEBURL="http://xxx/pingyou".$YEAR;
    $MAILBOTTOM="<hr /><p>此邮件由系统自动发出，请勿回复此邮件。有问题请发送邮件至xxx@xxx.com反馈！</p>";
    
    $mysql_server_name="localhost";
    $mysql_username="root";
    $mysql_password="test";
    $mysql_database="pingyou";
    $conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
    mysql_select_db($mysql_database,$conn);
    //mysql_query("");
    
    date_default_timezone_set('Asia/Shanghai');
    function fz_mysql_query($sql)
    {
        $myfile = fopen("sql.log", "a") or die("Unable to open file!");
        // fwrite($myfile, __FILE__ . ' @line ' . __LINE__ . ' : ' . $sql . ";\r\n");
        fwrite($myfile,$sql . "; -- " . date("Y-m-d H:i:s") . "\r\n");
        fclose($myfile);
        
        return mysql_query($sql);
    }
    
    $POLITICAL=array('--请选择政治面貌--','中国共产党党员','中国共产党预备党员','中国共产主义青年团团员','中国国民党革命委员会会员','中国民主同盟盟员','中国民主建国会会员','中国民主促进会会员','中国农工民主党党员','中国致公党党员','九三学社社员','台湾民主自治同盟盟员','无党派民主人士','群众');
    
    //修改奖项有4个位置要修改，此处(global.php)、main.php、info.php和infoupload.php！！！
    $AWARD = [
        100 => '十佳本科生',
        101 => '十佳研究生',
        200 => '三好学生',
        201 => '优秀学生干部',
        300 => '学风标兵',
        301 => '文艺标兵',
        302 => '体育标兵',
        303 => '公益标兵',
        304 => '社会实践标兵',
        305 => '科技创新标兵',
        400 => '本科生国家奖学金',
        401 => '硕士研究生国家奖学金',
        //研究生国家奖学金要分成硕士和博士。之前的全变成硕士。增加一个博士选项。
        419 => '博士研究生国家奖学金',
        402 => '国家励志奖学金',
        403 => '曾宪梓奖学金',
        404 => '中国石油奖学金',
        405 => '中国石化英才奖学金',
        406 => '杨起奖学金',
        407 => '杨遵仪奖学金',
        408 => '郝诒纯奖学金',
        409 => '冯景兰奖学金',
        410 => '地球化学人才奖学金',
        411 => '翟裕生奖学金',
        412 => '赵鹏大奖学金',
        413 => '希尔威矿业奖学金',
        414 => '航勘院地质奖学金',
        415 => '中国科学院奖学金',
        416 => '龙润奖学金',
        417 => 'SPE奖学金',
        418 => '刘光文奖学金',
        //给博士研究生国家奖学金分配419，在此占位以提示。
        //419
        500 => '自强之星',
        501 => '优秀学生党支部书记',
        600 => '优秀班集体',
        601 => '十佳班集体',
        700 => '优秀学生宿舍',
        701 => '十佳学生宿舍',
        800 => '先锋党支部'
    ];
?>
