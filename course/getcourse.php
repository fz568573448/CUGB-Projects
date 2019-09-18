<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGB课表抓取</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selection.css" media="all" />
  </head>
  <body>
    <?php
        session_start();
        require_once 'function.php';
        require_once 'simple_html_dom.php';
        //更新manifest文件
        updateCache();
        //使浏览器刷新一次
        setcookie("reload", "0", time()+360000000);
        
        $course=new cugbCourse;
        $no=$_POST["no"];
        setcookie("no", "", time()-360000000);
        setcookie("no", "$no", time()+360000000);
        $ret=$course->login($_POST["no"],$_POST["pw"],$_POST["ca"]);
        if ($ret)
        {
            //增加有课表的标记
            setcookie("course", "", time()-360000000);
            setcookie("course", "1", time()+360000000);
            
            //处理课表table
            $data=$course->loadCourse();
            $html = new simple_html_dom();
            $html->load($data);
            $res = $html->find('table');
            $table=$res[3]->innertext;
            
            //处理周末和晚上的cookies
            setcookie("weekends1", "", time()-360000000);
            setcookie("weekends2", "", time()-360000000);
            setcookie("evening", "", time()-360000000);
            if (preg_match('/星期六/',$table))  setcookie("weekends1", "1", time()+360000000);
            if (preg_match('/星期日/',$table))  setcookie("weekends2", "1", time()+360000000);
            if (preg_match('/第9-11节/',$table)) setcookie("evening", "1", time()+360000000);
            
            //得到每条记录
            $html = new simple_html_dom();
            $html->load($table);
            $res = $html->find('tr.infolist_common');
            $cnt=count($res);
            
            //处理一门课程
            $num=0;
            function solve($data,&$num)
            {
                $getday=array('一' => '1', '二' => '2', '三' => '3', '四' => '4', '五' => '5', '六' => '6', '日' => '7');
                strtr($data,"\r\n","  ");
                if (preg_match('/星期/',$data))
                {
                    $s="";
                    //处理课程数据
                    //课程名
                    preg_match('/infolist">(.*)\s+<\/a>/U',$data,$tmp);
                    $s.=$tmp[1]."|";
                    //任课教师
                    preg_match_all('/\_blank\'>(\S*)\s*<\/a>/U',$data,$tmp);
                    $s.=$tmp[1][0];
                    for ($i=1;$i<count($tmp[1]);$i++) $s.="、{$tmp[1][$i]}";
                    $s.='|';
                    //课程信息
                    preg_match_all('/<tr>(.*)<\/tr>/U',$data,$tmp);
                    $s.=count($tmp[1]);
                    for ($i=0;$i<count($tmp[1]);$i++)
                    {
                        $s.='|';
                        preg_match_all('/p>\s*(\S*)\s*</U',$tmp[1][$i],$tmp2);
                        $odd=0;
                        $even=0;
                        if (preg_match('/单/',$tmp2[1][0])) $odd=1;
                        if (preg_match('/双/',$tmp2[1][0])) $even=1;
                        //处理第几周
                        if (preg_match('/第/',$tmp2[1][0]))
                        {
                            preg_match('/第(\d*)周/',$tmp2[1][0],$tmp3);
                            $s.='.'.(int)$tmp3[1].'.';
                        }
                        else
                        {
                            preg_match('/(\d*)-(\d*)周/',$tmp2[1][0],$tmp3);
                            for ($j=$tmp3[1];$j<=$tmp3[2];$j++)
                            {
                                if ($j%2&&$even) continue;
                                if ($j%2==0&&$odd) continue;
                                $s.='.'.(int)$j.'.';
                            }
                        }
                        $s.='=';
                        //处理星期几
                        preg_match('/星期(.*)/',$tmp2[1][1],$tmp3);
                        $s.=$getday[$tmp3[1]].'=';
                        //处理第几节
                        preg_match('/(\d+)(\D*)(\d+)节/',$tmp2[1][2],$tmp3);
                        //echo $tmp3[1]." ".$tmp3[3]."<br />";
                        if ($tmp3[2]=='、') $s.='.'.($tmp3[1]+1)/2 .'.';
                        else
                        {
                            for ($j=$tmp3[1];$j<=$tmp3[3];$j++)
                                if ($j%2==0) $s.='.' . $j/2 .'.';
                        }
                        $s.='=';
                        $s.=$tmp2[1][3];
                    }
                    //存入cookies
                    $s=base64_encode($s);
                    // $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
                    // fwrite($myfile, $s."\r\n");
                    setcookie("course$num", "", time()-360000000);
                    setcookie("course$num", "$s", time()+360000000);
                    $num++;
                }
            }
            for ($i=0;$i<$cnt;$i++) solve($res[$i]->innertext,$num);
            
            //记录课程个数
            setcookie("num", "", time()-360000000);
            setcookie("num", "$num", time()+360000000);
            
            //debug
            //$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            //fwrite($myfile, $res[5]->innertext);
            
            echo '<div style="text-align:center"><a class="btn btn-lg btn-success" href=".">点击返回</a></div>';
            echo '<script type="text/javascript">window.location.href="."</script>';
        }
        else echo '<div style="text-align:center"><a class="btn btn-lg btn-warning" href=".">点击返回</a></div>';
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
