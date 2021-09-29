<?php

function echoFileLinks()
{
    echo "<h3 class='mt-5'>Error Files</h3>";
    echo "<ul>";
    $path_folder = realpath(__DIR__) . DIRECTORY_SEPARATOR . "logs";
    $file_paths = glob($path_folder . DIRECTORY_SEPARATOR . "*.json");
    foreach (array_reverse($file_paths) as $file_path) {
        $filename = basename($file_path);
        $url = "?fn=$filename";
        echo "<li><a href='$url'>$filename</a></li>";
    }
    echo "</ul>";
}

function echoFileTableIfSet()
{
    $filename = $_GET['fn'];
    if (!isset($filename)) {
        return;
    }

    $path_folder = realpath(__DIR__) . DIRECTORY_SEPARATOR . "logs";
    $file_path = $path_folder . DIRECTORY_SEPARATOR . $filename;
    $text = file_get_contents($file_path);
    $lines = array_reverse(explode("\n", $text));

    echo "<h3 class='mt-5'>{$filename}</h3>";
    echo "<table class='table table-striped table-hover border mx-auto'>";
    echo "<thead>";
    echo "<tr>";

    echo "<th scopt='col'>Error</th>";
    echo "<th scopt='col'>Time</th>";
    echo "<th scopt='col'>Broken URL</th>";
    echo "<th scopt='col'>Referrer</th>";
    echo "<th scopt='col'>User</th>";
    echo "<th scopt='col'>Agent</th>";

    echo "</tr>";
    echo "</thead>";

    foreach ($lines as $line) {

        if (strlen($line) < 3)
            continue;

        $info = json_decode($line, true);
        $code =  $info['code'];
        $ip =  $info['ip'];
        $utc = $info['utc'];
        $url = $info['url'];
        $ref = $info['ref'];
        $agent = $info['agent'];

        $utc = explode("T", $utc)[1];
        $utc = explode("+", $utc)[0];

        echo "<tr>";
        echo "<td class='font-monospace'>$code</td>";
        echo "<td class='font-monospace'>$utc</td>";
        echo "<td class='font-monospace'><a href='$url'>$url</a></td>";
        echo "<td class='font-monospace'><a href='$ref'>$ref</a></td>";
        echo "<td class='font-monospace text-muted'>$ip</td>";
        echo "<td class='text-muted' style='white-space:nowrap;'>$agent</td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>404 Dashboard</title>
    <style>
        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="p-3">
        <h1>404 Dashboard</h1>
        <?php echoFileTableIfSet(); ?>
        <?php echoFileLinks(); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>