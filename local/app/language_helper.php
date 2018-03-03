<?php 
function shr32($x, $bits)
{

    if($bits <= 0){
        return $x;
    }
    if($bits >= 32){
        return 0;
    }

    $bin = decbin($x);
    $l = strlen($bin);

    if($l > 32){
        $bin = substr($bin, $l - 32, 32);
    }elseif($l < 32){
        $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);
    }

    return bindec(str_pad(substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));
}        

function charCodeAt($str, $index)
{
    $char = mb_substr($str, $index, 1, 'UTF-8');
 
    if (mb_check_encoding($char, 'UTF-8'))
    {
        $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
        return hexdec(bin2hex($ret));
    }
    else
    {
        return null;
    }
}

function mb_str_split($str, $length = 1) 
{
    if ($length < 1) return false;
    $result = array();
    for ($i = 0; $i < mb_strlen($str); $i += $length) {
        $result[] = mb_substr($str, $i, $length);
    }
    return $result;
}
        
function RL($a, $b)
{
    for($c = 0; $c < strlen($b) - 2; $c +=3) {
        $d = $b{$c+2};
        $d = $d >= 'a' ? charCodeAt($d,0) - 87 : intval($d);
        $d = $b{$c+1} == '+' ? shr32($a, $d) : $a << $d;
        $a = $b{$c} == '+' ? ($a + $d & 4294967295) : $a ^ $d;
    }
    return $a;
}


function sendHttpRequest($url, $post, $requestBody, $headers) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $curl_errno = curl_errno($ch); 
    $curl_error = curl_error($ch); 
    curl_close($ch);
    
    if( $curl_errno > 0 ){ 
        return "$curl_error";
    }       

    return $response;
}

function TKK() 
{
    //unset($_SESSION['engine_google_token']);

    if( isset($_SESSION['engine_google_token']) && !empty($_SESSION['engine_google_token']) ) {
        return $_SESSION['engine_google_token'];
    }

    // Random user agents DB
    $userAgents = array (
            "Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0",
            "Mozilla/5.0 (X11; Linux i586; rv:31.0) Gecko/20100101 Firefox/31.0",
            "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20130401 Firefox/31.0",
            "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1944.0 Safari/537.36",
            "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A",
            "Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25",
            "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko",
            "Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Macintosh; Intel Mac OS X 10_7_3; Trident/6.0)"
                    );
    $ua = $userAgents [rand ( 0, count ( $userAgents ) - 1 )];
    
    $_SESSION['User-Agent'] = $ua;
    
    
    $headers = array (
            'Cache-Control' => 'max-age=0',
            'User-Agent' => $ua,
            'Accept' => 'text/html',
            'Referer' => 'https://translate.google.com/',
            'Accept-Language' => 'en-GB, en'
    );

    $bodyResponsePage = sendHttpRequest( "https://translate.google.com", 0, '', $headers );
    
    //if ( isset($_GET['debug']) ) var_dump($bodyResponsePage);

    preg_match('/TKK.*return\s?-?\d+/', $bodyResponsePage, $AandBArray);
    
    $periodsExploded = explode(';', $AandBArray[0]);

    // First var $a
    $aExploded = explode('\x3d', $periodsExploded[0]);
    $a = $aExploded[1];

    // Second var $b
    $bExploded = explode('\x3d', $periodsExploded[1]);
    $b = $bExploded[1];

    // Third var hours - Unix elapsed
    $hoursExploded = explode('return', $periodsExploded[2]);
    $hoursElapsed = trim($hoursExploded[1]);

    $_SESSION['engine_google_token']  = $hoursElapsed . '.' . ($a + $b);
    
    //if ( isset($_GET['debug']) ) var_dump($_SESSION['engine_google_token']);

    return $hoursElapsed . '.' . ($a + $b);
}


function TL($a) 
{
    
    $tkk = explode('.', TKK());
    $b = $tkk[0];

    for($d = array(), $e = 0, $f = 0; $f < mb_strlen ( $a, 'UTF-8' ); $f ++) {
        $g = charCodeAt ( $a, $f );
        if (128 > $g) {
            $d [$e ++] = $g;
        } else {
            if (2048 > $g) {
                $d [$e ++] = $g >> 6 | 192;
            } else {
                if (55296 == ($g & 64512) && $f + 1 < mb_strlen ( $a, 'UTF-8' ) && 56320 == (charCodeAt ( $a, $f + 1 ) & 64512)) {
                    $g = 65536 + (($g & 1023) << 10) + (charCodeAt ( $a, ++ $f ) & 1023);
                    $d [$e ++] = $g >> 18 | 240;
                    $d [$e ++] = $g >> 12 & 63 | 128;
                } else {
                    $d [$e ++] = $g >> 12 | 224;
                    $d [$e ++] = $g >> 6 & 63 | 128;
                }
            }
            $d [$e ++] = $g & 63 | 128;
        }
    }
    $a = $b;
    for($e = 0; $e < count ( $d ); $e ++) {
        $a += $d [$e];
        $a = RL ( $a, '+-a^+6' );
    }
    $a = RL ( $a, "+-3^+b+-f" );
    $a ^= $tkk[1];
    if (0 > $a) {
        $a = ($a & 2147483647) + 2147483648;
    }
    $a = fmod ( $a, pow ( 10, 6 ) );
    return $a . "." . ($a ^ $b);
}

function translate($sl, $tl, $q)
{
    
    $tk = TL($q);
    $q = urlencode(stripslashes($q));
    
    $url = "https://translate.google.com/translate_a/t?client=webapp&sl=".$sl."&tl=".$tl."&hl=".$tl."&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&ie=UTF-8&oe=UTF-8&otf=2&ssel=0&tsel=0&kc=1&tk=". $tk ."&q=" . $q;

    $output = json_decode(file_get_contents($url));
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_USERAGENT, $_SESSION['User-Agent']);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 30);    
    // $output = curl_exec($ch);
    // curl_close($ch);
    // dd($output);
    
    return str_replace('"', '', $output);


}