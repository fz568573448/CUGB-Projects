<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUGB空教室查询</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selection.css" media="all" />
  </head>
  <body>
    <?php
        session_start();
        require_once 'function.php';
        require_once 'simple_html_dom.php';
        $course=new cugbCourse;
        $ret=false;
        if (isset($_POST["no"])) $ret=$course->login($_POST["no"],$_POST["pw"],$_POST["ca"]);
        if (!isset($_POST["no"])) echo '<script type="text/javascript">window.location.href="."</script>';
        if ($ret)
        {
            function solve($buildingid)
            {
                $a=array();
                global $course;
                $tmp=$course->loadEmpty($buildingid,$_POST["ww"],$_POST["wk"]);
                $tmp1 = new simple_html_dom();
                $tmp1->load($tmp);
                $tmp2 = $tmp1->find('table.infolist_tab tr.infolist_common');
                $n=count($tmp2);
                $cnt=0;
                for ($i=0;$i<$n;$i++)
                {
                    $tmp3 = $tmp2[$i]->find('td');
                    $tmp4 = $tmp3[0]->innertext;
                    $l=strlen($tmp4);
                    if ($tmp4[$l-4]=='B'||$tmp4[$l-3]=='1') continue;
                    $a[$cnt++][0]=(int)substr($tmp4,$l-3);
                    
                    $tmp5=$tmp3[6]->find('table tr');
                    $tmp6=$tmp5[1]->find('td');
                    for ($j=1;$j<=5;$j++)
                        if ($tmp6[($j-1)*2]->innertext=='&nbsp;'&&$tmp6[($j-1)*2+1]->innertext=='&nbsp;')
                            $a[$cnt-1][$j]=1;
                        else $a[$cnt-1][$j]=0;
                }
                // $a[$cnt][0]=0;
                return $a;
            }
            echo '
    <style type="text/css">
    table, td {
        border: 1px solid #DDDDDD;
    }
    td {
        text-align: center;
        width: 128px;
        font-weight: bold;
        font-size: 16px;
    }';
    if ($_POST["wk"]==1)
    {
        $col1='CC0000';
        $col2='FF0000';
        $col3='FF3300';
        $col4='CC3300';
    }
    else if ($_POST["wk"]==2)
    {
        $col1='FF9900';
        $col2='CC9900';
        $col3='FF6600';
        $col4='FF6600';
    }
    else if ($_POST["wk"]==3)
    {
        $col1='FFCC00';
        $col2='CCCC00';
        $col3='FFCC00';
        $col4='CCCC00';
    }
    else if ($_POST["wk"]==4)
    {
        $col1='92D050';
        $col2='008000';
        $col3='00B050';
        $col4='00CC99';
    }
    else if ($_POST["wk"]==5)
    {
        $col1='009999';
        $col2='33CCCC';
        $col3='00FFFF';
        $col4='33CCFF';
    }
    else
    {
        $col1='0';
        $col2='0';
        $col3='0';
        $col4='0';
    }
    echo "
    .row1 td {
        color: #$col1;
    }
    .row2 td {
        color: #$col2;
    }
    .row3 td {
        color: #$col3;
    }
    .row4 td {
        color: #$col4;
    }";
    echo '
    .main {
        margin: 0 auto;
        width: 768px;
    }
    </style>
    <div class="main">
    <table>
    	<tr>
    		<td>&nbsp;</td>
    		<td>1、2节</td>
    		<td>3、4节</td>
    		<td>5、6节</td>
    		<td>7、8节</td>
    		<td>9-11节</td>
    	</tr>';
        $a;
        $n;
        $fl;
        $flnum;
        $num;
        function calc($buildingid)
        {
            global $a;
            global $n;
            global $fl;
            global $flnum;
            global $num;
            $a=solve($buildingid);
            // var_dump($a);
            $n=count($a);
            //楼层分别是多少
            $fl=array();
            //楼层数
            $flnum=0;
            //第i层有几个教室
            $num=array();
            for ($i=0;$i<$n;$i++)
            {
                $tmp=(int)($a[$i][0]/100);
                if (isset($num[$tmp])) $num[$tmp]++;
                else $num[$tmp]=1;
                // echo $i;
                if (!isset($a[$i+1][0])||$tmp!=(int)($a[$i+1][0]/100)) $fl[++$flnum]=$tmp;
                // echo $tmp . ' ' . (int)($a[$i+1][0]/100) . '<br />';
            }
        }
        function output($buildingid,$id)
        {
            global $a;
            global $n;
            global $fl;
            global $flnum;
            global $num;
            // echo $flnum.'<br />';
            for ($i=$flnum;$i>=1;$i--)
            {
                if ($i!=$flnum) echo "<tr class=\"row$id\">";
                for ($j=1;$j<=5;$j++)
                {
                    echo '<td>';
                    $usedroom=0;
                    for ($k=0;$k<$n;$k++)
                        if ($a[$k][$j]==0&&$fl[$i]==(int)($a[$k][0]/100)) $usedroom++;
                    if ($usedroom<=3&&$num[$fl[$i]]-$usedroom>=8)
                    {
                        if ($usedroom) echo '除<br />';
                        for ($k=0;$k<$n;$k++)
                            if ($a[$k][$j]==0&&$fl[$i]==(int)($a[$k][0]/100))
                                echo $a[$k][0].'<br />';
                        if (!$usedroom) echo "{$fl[$i]}楼<br />";
                        echo '全空';
                    }
                    else if (!$usedroom) echo "{$fl[$i]}楼<br />全空";
                    else
                    {
                        for ($k=0;$k<$n;$k++)
                            if ($a[$k][$j]==1&&$fl[$i]==(int)($a[$k][0]/100))
                                echo $a[$k][0].'<br />';
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
        echo "<h3 style=\"text-align: center;     font-family: Microsoft YaHei, sans-serif;\">第{$_POST["ww"]}周 周{$_POST["wk"]}空教室表</h3>";
        //综合楼 80
        //科研楼 1021
        //19楼 10
        //教一楼 164
        calc(80);
        echo "<tr class=\"row1\"><td rowspan=\"$flnum\">综<br />合<br />楼</td>";
        output(80,1);
        calc(1021);
        echo "<tr class=\"row2\"><td rowspan=\"$flnum\">科<br />研<br />楼</td>";
        output(1021,2);
        calc(10);
        echo "<tr class=\"row3\"><td rowspan=\"$flnum\">19<br />楼</td>";
        output(10,3);
        calc(164);
        echo "<tr class=\"row4\"><td rowspan=\"$flnum\">教<br />一<br />楼</td>";
        output(164,4);
            echo '
    </table></div>';
            echo '<div class="alert alert-info" style="text-align:center; margin-bottom: 0;" role="alert">若发现BUG，请发送邮件至xxx@xxx.com反馈</div>';
        }
        else echo '<div style="text-align:center"><a class="btn btn-lg btn-success" href=".">点击返回</a></div>';
    ?>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>