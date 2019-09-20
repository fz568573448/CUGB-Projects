<?php
    require 'simple_html_dom.php';
    date_default_timezone_set('Asia/Shanghai');
    
    $conn=new mysqli("localhost", "root", "test", "rating");
    $info=$conn->query("SELECT * FROM `info`")->fetch_all();
    
    $cnt=count($info);
    for ($i=0;$i<$cnt;$i++)
    {
        $a=$info[$i];
        
        $data=file_get_contents("http://www.codeforces.com/profile/{$a[1]}",false,$proxy);
        if (preg_match("/<span style=\"font-weight:bold;\" class=\"(.+)\">(\d+)<\/span>.*\(max/",$data,$ret))
        {
            $conn->query("UPDATE `info` SET `cf`={$ret[2]},`cfcolor`='{$ret[1]}' WHERE `name`='{$a[0]}'");
        }
        
        $data=file_get_contents("http://bestcoder.hdu.edu.cn/rating.php?user={$a[4]}",false,$proxy);
        if (preg_match("/RATING[^0-9]*<span class=\"bigggger\">(\d+)<\/span>/",$data,$ret))
        {
            $level=floor(max($ret[1]-900,0)/200+1);
            $bccolor='level'.$level;
            if ($ret[1]==0) $bccolor='none';
            $conn->query("UPDATE `info` SET `bc`={$ret[1]},`bccolor`='$bccolor' WHERE `name`='{$a[0]}'");
        }
    }
?>
