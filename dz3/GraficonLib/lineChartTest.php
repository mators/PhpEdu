<?php

header('Content-Type: image/png');

require_once('../autoloader.php');

use hr\sofascore\dz3\graficonlib\Legend;
use hr\sofascore\dz3\graficonlib\LegendItem;
use hr\sofascore\dz3\graficonlib\LineChart;
use hr\sofascore\dz3\graficonlib\DataCollection;
use hr\sofascore\dz3\graficonlib\DataCollectionItem;


$lineChart = new LineChart("BATMAN (malo lici na macku)", 500, 500);
$lineChart->set_font_size(5);

$data = new DataCollection();
$data->add_items([
    new DataCollectionItem(60, "1"),
    new DataCollectionItem(10, "2"),
    new DataCollectionItem(5, "3"),
    new DataCollectionItem(4, "4"),
    new DataCollectionItem(4, "5"),
    new DataCollectionItem(5, "6"),
    new DataCollectionItem(10, "7"),
    new DataCollectionItem(60, "8")
]);
$ids = $lineChart->add_data($data);
$lineChart->color_data(0, 0, 255, $ids);

$data2 = new DataCollection();
$data2->add_items([
    new DataCollectionItem(60, "1"),
    new DataCollectionItem(90, "2"),
    new DataCollectionItem(60, "3"),
    new DataCollectionItem(65, "4"),
    new DataCollectionItem(65, "5"),
    new DataCollectionItem(60, "6"),
    new DataCollectionItem(90, "7"),
    new DataCollectionItem(60, "8")
]);
$ids2 = $lineChart->add_data($data2);
$lineChart->color_data(255, 0, 0, $ids2);

$legend = new Legend([
    new LegendItem("Batmanove usi", 255, 0, 0),
    new LegendItem("Batmanova brada", 0, 0, 255)
]);
$legend->set_font_size(4);
$lineChart->set_legend($legend, 200, 200);


imagepng($lineChart->render());