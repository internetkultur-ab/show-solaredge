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
<html lang="se">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/picocss/1.5.2/pico.min.css" integrity="sha512-3gFq2IXMVlAQaUyahzhjDRivv0yqyXTb7xiy6ivTaG5Uz4hKI54uYxpQefdomgDVQ11eJVUbXG0YdPMDISiGgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Hello, world!</title>
  </head>
  <body>
    <main class="container">
      <p>Produktion just nu: <?php echo $data['overview']['currentPower']['power'] / 100 ; ?> kW</p>
      <p>Dagens produktion: <?php echo $data['overview']['lastDayData']['energy'] / 1000; ?> kWh</p>
      <p>Månadens produktion: <?php echo $data['overview']['lastMonthData']['energy'] / 1000000; ?> MWh</p>
      <p>Sedan installation: <?php echo $data['overview']['lifeTimeData']['energy'] / 1000000; ?> MWh</p>
      <p>Senast uppdaterad: <?php echo $data['overview']['lastUpdateTime']; ?></p>
    </main>
  </body>
</html>