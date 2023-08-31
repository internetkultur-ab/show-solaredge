<?php

if (!isset($_GET['key']) or empty($_GET['key']) or !isset($_GET['site']) or empty($_GET['site'])) {
    die();
}


function getData($key, $site) {
    $url = "https://monitoringapi.solaredge.com/site/" . $site . "/overview?api_key=". $key ."";
    $options = [
        "http" => [
            "header" => "accept: application/json",
            "method" => "GET",
            "content" => "",
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $data = json_decode($result, true);
    return $data;

}

print_r($data);

?>