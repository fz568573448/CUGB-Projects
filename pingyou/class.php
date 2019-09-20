<?php
class Base {
    public static function curl_request($url, $postData, $cookie, array $options = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //只通过结果返回，不自动输出
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //if ($url[4]=='s')
        //{
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        //}
        if (isset($postData) && !empty($postData)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        if (isset($cookie) && !empty($cookie)) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if (isset($options) && !empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $result = curl_exec($ch);
        //$result = curl_getinfo($ch);
        //var_dump($result);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === FALSE) {
            //echo $url . "<br />" . $cookie;
            //echo ("curl_request failed. {$error}. \$url is $url") . "<br />";
            return FALSE;
        }
        return $result;
    }
}
class SZXY {
    public function setCookies($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //只通过结果返回，不自动输出
        //if ($url[4]=='s')
        //{
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
            //echo "###" . $url . "<br />";
        //}
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header_line) {
            $matches = array();
            if (preg_match("/set\-cookie:([^\r\n]*)/i", $header_line, $matches)) {
                $_SESSION["remote_cookie"] = $matches[1];
            }
            return strlen($header_line);
        });
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        if (curl_exec($ch)) {
            return $_SESSION["remote_cookie"];
        } else {
            curl_close($ch);
            return FALSE;
        }
    }
    public function getcaptcha() {
        $this->setCookies('https://www.cugb.edu.cn:8443/cas/security/initDigitPicture.do');
        return base64_encode(Base::curl_request("https://www.cugb.edu.cn:8443/cas/security/initDigitPicture.do", "", $_SESSION["remote_cookie"]));
    }
    public $newURL;
    public function getHtmlGetCookies($url, $post, $cookie) {
        if ($url[7]!='2') $cookie=$_SESSION["remote_cookie"];
        else $cookie=$_SESSION["remote_cookie_xg"];
        //echo $url . "~~~~~~~~" . $cookie . "<br />";
        $charset = "UTF-8";
        $tempURL=$this->newURL;
        $res = Base::curl_request($url, $post, $cookie, [
            CURLOPT_HEADER => FALSE,
            CURLOPT_HEADERFUNCTION => function($ch, $header_line) use(&$charset,&$url,&$tempURL) {
                //获取新的cookies
                $cookies = array();
                $location = array();
                $flag=0;
                if (preg_match("/Location: ([^\r\n]*)/i", $header_line, $location)) {
                    if ($location[1][7]!='2') $flag=1;
                    $tempURL=$location[1];
                }
                else
                {
                    if ($url[7]!='2') $flag=1;
                }
                if (preg_match("/set\-cookie:([^\r\n]*)/i", $header_line, $cookies)) {
                    if ($flag)
                    {
                        if ($_SESSION["remote_cookie"]!="") $_SESSION["remote_cookie"] .= "; ";
                        $_SESSION["remote_cookie"] .= $cookies[1];
                        //echo "###" . $_SESSION["remote_cookie"] . "###<br />";
                    }
                    else
                    {
                        if ($_SESSION["remote_cookie_xg"]!="") $_SESSION["remote_cookie_xg"] .= "; ";
                        $_SESSION["remote_cookie_xg"] .= $cookies[1];
                        //echo "###" . $_SESSION["remote_cookie_xg"] . "###<br />";
                    }
                }
                $matches = array();
                //echo $header_line . "<br />";
                if (preg_match_all('/charset=(.*)/i', $header_line, $matches)) {
                    $charset = trim(array_pop($matches[1]));
                }
                return strlen($header_line);
            },
                    // CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_AUTOREFERER => true,
                    CURLOPT_MAXREDIRS => 5,
                    CURLOPT_TIMEOUT => 15,
                    CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36"
        ]);
        if ($res === FALSE) {
            return FALSE;
        }
        $body = trim((iconv($charset, "UTF-8//IGNORE", $res)));
        $this->newURL=$tempURL;
        return $body;
    }
    public function getHtml($url, $post, $cookie) {
        $charset = "UTF-8";
        $res = Base::curl_request($url, $post, $cookie, [
            CURLOPT_HEADER => FALSE,
            CURLOPT_HEADERFUNCTION => function($ch, $header_line) use(&$charset) {
                $matches = array();
                //echo $header_line . "<br />";
                if (preg_match_all('/charset=(.*)/i', $header_line, $matches)) {
                    $charset = trim(array_pop($matches[1]));
                }
                return strlen($header_line);
            },
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                    CURLOPT_MAXREDIRS => 5,
                    CURLOPT_TIMEOUT => 15,
                    CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36"
        ]);
        if ($res === FALSE) {
            return FALSE;
        }
        $body = trim((iconv($charset, "UTF-8//IGNORE", $res)));
        return $body;
    }
    public function login($StudentId = "", $Password = "", $Verification = "") {
        $page=$this->getHtml("https://www.cugb.edu.cn:8443/cas/login", "", $_SESSION["remote_cookie"]);
        $dom = new simple_html_dom();
        $dom->load($page);
        $lt=$dom->find('input[name=lt]',0)->value;
        $post = "username={$StudentId}&password={$Password}&j_digitPicture={$Verification}&lt={$lt}&execution=e1s1&_eventId=submit";
        //echo $post;
        //$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        //fwrite($myfile, $post);

        $_SESSION["remote_cookie_xg"]="";
        $data=$this->getHtmlGetCookies("https://www.cugb.edu.cn:8443/cas/login", $post, "");
        if (preg_match('/登录成功/',$data)) return 0;
        else
        {
            if (preg_match('/您提供的用户名或密码错误！/',$data)) return 1;
            else return 2; //验证码错误
        }
        //echo $data;
    }
    public function loadInfo()
    {
        $this->getHtmlGetCookies("http://202.204.105.83/xg/", "", "");
        $this->getHtmlGetCookies($this->newURL, "", "");
        $this->getHtmlGetCookies($this->newURL, "", "");
        $this->getHtmlGetCookies($this->newURL, "", "");
        $data=$this->getHtmlGetCookies("http://202.204.105.83/xg/xg/studentInfo.do?method=getStudentInfo", "", "");
        // $data=$this->getHtml("http://202.204.105.83/xg/xg/studentInfo.do?method=getStudentInfo", "", $_SESSION["remote_cookie"]);
        // echo "#####<br />" . $_SESSION["remote_cookie"] . "<br />#####";
        //$data=$this->getHtml("http://202.204.105.83/xg/", "", $_SESSION["remote_cookie"]);
        
        // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        // fwrite($myfile, $data);
        
        $dom = new simple_html_dom();
        $dom->load($data);
        $dom=$dom->find('table.heertable')[0];
        $dom=$dom->find('tr');
        $name=$dom[1]->find('td')[3]->innertext;
        //echo $dom->innertext;
        $sex=$dom[3]->find('td')[1]->innertext;
        $sex=substr($sex,6);
        $department=$dom[5]->find('td')[1]->innertext;
        $department=substr($department,6);
        $major=$dom[6]->find('td')[1]->innertext;
        $major=substr($major,6);
        return array($name,$sex,$department,$major);
    }
}
//处理HTML的类
require 'simple_html_dom.php';
?>
