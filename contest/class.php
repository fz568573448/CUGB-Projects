<?php
class Base {
    public static function curl_request($url, $postData, $cookie, array $options = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
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
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === FALSE) {
            
            Log::addErrorLog("curl_request failed. {$error}. \$url is $url");
            return FALSE;
        }
        return $result;
    }
}
class JWC {
    public function setCookies($url) {
        $ch = curl_init();
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
        $this->setCookies('http://202.204.105.22/academic/j_acegi_security_check');
        return base64_encode(Base::curl_request("http://202.204.105.22/academic/getCaptcha.do", "", $_SESSION["remote_cookie"]));
    }
    public function getHtml($url, $post, $cookie) {
        $charset = "UTF-8";
        $res = Base::curl_request($url, $post, $cookie, [
            CURLOPT_HEADER => FALSE,
            CURLOPT_HEADERFUNCTION => function($ch, $header_line) use(&$charset) {
                $matches = array();
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
        $post = "j_username={$StudentId}&j_password={$Password}&j_captcha={$Verification}";
        $data=$this->getHtml("http://202.204.105.22/academic/j_acegi_security_check", $post, $_SESSION["remote_cookie"]);
        if (preg_match('/您输入的验证码不正确/',$data)) return 1;
        else
        {
            if (preg_match('/密码不匹配/',$data)) return 2;
            else
            {
                if (preg_match('/不存在/',$data)) return 3;
                else return 4;
            }
        }
    }
    public function loadInfo()
    {
        $data = $this->getHtml("202.204.105.22/academic/student/studentinfo/studentInfoModifyIndex.do?frombase=0&wantTag=0&groupId=&moduleId=2060", "", $_SESSION["remote_cookie"]);
        $dom = new simple_html_dom();
        $dom->load($data);
        $dom=$dom->find('table',0);
        $dom=$dom->find('tr');
        $name=$dom[1]->find('td',0)->plaintext;
        //echo $dom->innertext;
        $sex=$dom[2]->find('td',1)->plaintext;
        $department=$dom[19]->find('td',0)->plaintext;
        $major=$dom[19]->find('td',1)->plaintext;
        return array($name,$sex,$department,$major);
    }
}
//处理HTML的类
require 'simple_html_dom.php';
?>
