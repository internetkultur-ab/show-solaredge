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
$data = getData($_GET['key'], $_GET['site']);


?>
<!doctype html>
<html lang="sv">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
  <title>Solaredge</title>
</head>

<body>

  <div class="parent">
    <div class="div1 box">
      <p class="key">Aktuell effekt</p>
      <p class="value1"><?php echo number_format($data['overview']['currentPower']['power'] / 1000, 2, ",", "") ; ?></p>
      <p class="value2">kW</p>
    </div>
    <div class="div2 box">
      <p class="key">Energi idag</p>
      <p class="value1"><?php echo number_format($data['overview']['lastDayData']['energy'] / 1000, 2, ",", ""); ?></p>
      <p class="value2">kWh</p>
    </div>
    <div class="div3 box">
      <p class="key">Månadsenergi</p>
      <p class="value1"><?php echo number_format($data['overview']['lastMonthData']['energy'] / 1000000, 2, ",", ""); ?></p>
      <p class="value2">MWh</p>
    </div>
    <div class="div4 box">
      <p class="key">Total energi</p>
      <p class="value1"><?php echo number_format($data['overview']['lifeTimeData']['energy'] / 1000000, 2, ",", ""); ?></p>
      <p class="value2">MWh</p>
    </div>
  </div>
</body>

</html>