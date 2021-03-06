<?php

header('Content-Type: image/png');

require_once('../autoloader.php');

use hr\sofascore\dz3\graficonlib\Legend;
use hr\sofascore\dz3\graficonlib\LegendItem;
use hr\sofascore\dz3\graficonlib\LineChart;
use hr\sofascore\dz3\graficonlib\BarChart;
use hr\sofascore\dz3\graficonlib\PieChart;
use hr\sofascore\dz3\graficonlib\DataCollection;
use hr\sofascore\dz3\graficonlib\DataCollectionItem;
use hr\sofascore\dz3\graficonlib\Canvas;


$canvas = new Canvas(1000, 800);

// Bar chart
$barChart = new BarChart("BATMAN DATA", 400, 650);
$barChart->set_font_size(5);

$data = new DataCollection();
$data->add_items([
    new DataCollectionItem(20, "1"),
    new DataCollectionItem(35, "2"),
    new DataCollectionItem(18, "3"),
    new DataCollectionItem(62, "4"),
    new DataCollectionItem(5, "5"),
    new DataCollectionItem(42, "6"),
    new DataCollectionItem(120, "7"),
    new DataCollectionItem(5, "8")
]);
$ids = $barChart->add_data($data);
$barChart->color_data(0, 255, 0, $ids);

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
$ids2 = $barChart->add_data($data2);
$barChart->color_data(255, 0, 0, $ids2);

$data3 = new DataCollection();
$data3->add_items([
    new DataCollectionItem(60, "1"),
    new DataCollectionItem(10, "2"),
    new DataCollectionItem(5, "3"),
    new DataCollectionItem(4, "4"),
    new DataCollectionItem(4, "5"),
    new DataCollectionItem(5, "6"),
    new DataCollectionItem(10, "7"),
    new DataCollectionItem(60, "8")
]);
$ids3 = $barChart->add_data($data3);
$barChart->color_data(0, 0, 255, $ids3);

$legend = new Legend([
    new LegendItem("Batmanove usi", 255, 0, 0),
    new LegendItem("Batmanova brada", 0, 0, 255),
    new LegendItem("Jos nesto dodatno", 0, 255, 0)
]);
$legend->set_font_size(4);
$barChart->set_legend($legend, 250, 100);

// Line chart
$lineChart = new LineChart("BATMAN (malo lici na macku)", 400, 500);
$lineChart->set_font_size(5);

$ids4 = $lineChart->add_data($data2);
$lineChart->color_data(255, 0, 0, $ids4);

$ids5 = $lineChart->add_data($data3);
$lineChart->color_data(0, 0, 255, $ids5);

$legend2 = new Legend([
    new LegendItem("Batmanove usi", 255, 0, 0),
    new LegendItem("Batmanova brada", 0, 0, 255)
]);
$legend2->set_font_size(4);
$lineChart->set_legend($legend2, 200, 200);

// Pie chart
$pieChart = new PieChart("Pita", 400, 500);
$pieChart->set_font_size(5);

$pieData = new DataCollection();
$pieData->add_items([
    new DataCollectionItem(10, "1")
]);
$ids6 = $pieChart->add_data($pieData);
$pieChart->color_data(255, 0, 0, $ids6);

$pieData2 = new DataCollection();
$pieData2->add_items([
    new DataCollectionItem(25, "2")
]);
$ids7 = $pieChart->add_data($pieData2);
$pieChart->color_data(0, 255, 0, $ids7);

$pieData3 = new DataCollection();
$pieData3->add_items([
    new DataCollectionItem(15, "3")
]);
$ids8 = $pieChart->add_data($pieData3);
$pieChart->color_data(0, 0, 255, $ids8);

$legend3 = new Legend([
    new LegendItem("Dio pite", 255, 0, 0),
    new LegendItem("Dio pite", 0, 0, 255),
    new LegendItem("Dio pite", 0, 255, 0)
]);
$legend3->set_font_size(4);
$pieChart->set_legend($legend3, 20, 20);

$canvas->add_chart($barChart, 0, 400);
$canvas->add_chart($lineChart, 0, 0);
$canvas->add_chart($pieChart, 500, 0);


imagepng($canvas->render());