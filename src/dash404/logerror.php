<?php

/* 
    Importing this file logs the request to the date-coded log file. 
*/

date_default_timezone_set("UTC");
$datetime_utc = new DateTime();

$info = array(
    "url" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
    "code" => http_response_code(),
    "utc" => $datetime_utc->format("c"),
    "day" => $datetime_utc->format("Y-m-d"),
    "micro" => microtime(true),
    "ref" => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "",
    "ip" => $_SERVER['REMOTE_ADDR'],
    "agent" => $_SERVER['HTTP_USER_AGENT'],
);

$path_file = realpath(__DIR__) . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . $info["day"] . ".json";
file_put_contents($path_file, json_encode($info) . "\n", FILE_APPEND);

//echo "<!-- error logged https://github.com/swharden/Dash404 -->";