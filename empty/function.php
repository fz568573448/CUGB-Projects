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
class cugbCourse {
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
        $this->setCookies('http://jwc.cugb.edu.cn/academic/j_acegi_security_check');
        return base64_encode(Base::curl_request("http://jwc.cugb.edu.cn/academic/getCaptcha.do", "", $_SESSION["remote_cookie"]));
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
    public function getHtmlNoRedirAndUpdateCookies($url, $post, $cookie) {
        $charset = "UTF-8";
        $res = Base::curl_request($url, $post, $cookie, [
            CURLOPT_HEADER => FALSE,
            CURLOPT_HEADERFUNCTION => function($ch, $header_line) use(&$charset) {
                $matches = array();
                if (preg_match_all('/charset=(.*)/i', $header_line, $matches)) {
                    $charset = trim(array_pop($matches[1]));
                }
                if (preg_match("/set\-cookie:([^\r\n]*)/i", $header_line, $matches)) {
                    $_SESSION["remote_cookie"] = $matches[1];
                }
                if (preg_match("/login_error/i", $header_line, $matches)) {
                    $_SESSION["login_error"]=true;
                }
                return strlen($header_line);
            },
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_AUTOREFERER => true,
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
        $Captchapost = "captchaCode={$Verification}";
        $Captchadata=$this->getHtml("http://jwc.cugb.edu.cn/academic/checkCaptcha.do", $Captchapost, $_SESSION["remote_cookie"]);
        if ($Captchadata=="false") echo '<div class="alert alert-danger" style="text-align:center" role="alert">验证码不正确！</div>';
        else
        {
            $post = "j_username={$StudentId}&j_password={$Password}&j_captcha={$Verification}";
            $_SESSION["login_error"]=false;
            $data=$this->getHtmlNoRedirAndUpdateCookies("http://jwc.cugb.edu.cn/academic/j_acegi_security_check", $post, $_SESSION["remote_cookie"]);
            if ($_SESSION["login_error"]==true) echo '<div class="alert alert-danger" style="text-align:center" role="alert">用户名密码错误或账户已被停用！</div>';
            else
            {
                echo '<div class="alert alert-success" style="text-align:center" role="alert"><p>获取成功！</p><p>若拷贝到word中时格式不正确，原因是拷贝的内容不全，可以使用Ctrl+A全选后进行拷贝</p></div>';
                return true;
            }
        }
        return false;
    }
    public function loadEmpty($buildingid, $whichweek, $week) {
        $data = $this->getHtml("http://jwc.cugb.edu.cn/academic/teacher/teachresource/roomschedule_week.jsdo?aid=3&buildingid=$buildingid&whichweek=$whichweek&week=$week", "", $_SESSION["remote_cookie"]);
        return $data;
    }
}
?>
