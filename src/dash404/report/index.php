<?php

date_default_timezone_set("UTC");
$datetime_utc = new DateTime();

$info = array(
    "url" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
    "code" => http_response_code(),
    "utc" => $datetime_utc->format("c"),
    "day" => $datetime_utc->format("Y-m-d"),
    "micro" => microtime(true),
    "ref" => $_SERVER['HTTP_REFERER'],
    "ip" => $_SERVER['REMOTE_ADDR'],
    "agent" => $_SERVER['HTTP_USER_AGENT'],
);

$path_folder = realpath(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "logs";
$path_file = $path_folder . DIRECTORY_SEPARATOR . $info["day"] . ".json";
file_put_contents($path_file, json_encode($info) . "\n", FILE_APPEND);

?>

<html>

<head>
    <title>404: Page Not Found</title>
</head>

<body style='padding: 1em;'>

    <h1>404: Page Not Found</h1>

    <div>
        Return to the <a href='/'>main website</a>
    </div>

    <div style='font-family: monospace; padding-top: 1.5em;'>
        <div><?php echo $info["url"]; ?></div>
        <div><?php echo $info["utc"]; ?></div>
        <div>This error has been reported</div>
    </div>
</body>

</html>