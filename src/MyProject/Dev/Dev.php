<?php

require '../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$url = $_POST['url'];
$crawler = $client->request('GET', $url);
$images = $crawler->filter('img')->extract(['src']);

echo "<table border='1' cellspacing='1' cellpadding='1'>";
$i = 1;
$totalImages = count($images);
$totalSize = 0;

foreach ($images as $image) {
    $headers = get_headers($image, 1);

    if ($headers) {
        $filesize = (int)$headers['Content-Length'];
        $totalSize += $filesize;
    }

    echo "<td><img style='width: 150px; height: 100px;' src='$image' alt='Image $i'></td>";

    if ($i % 4 === 0) {
        echo "<tr>";
    }

    $i++;
}
echo "</table>";

echo "На странице обнаружено {$totalImages} изображений на " . round(($totalSize/1024/1024), 2) .  " Мб.";