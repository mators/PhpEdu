<?php

	header('Content-Type: text/html; charset=utf-8');

	$n = (isset($_GET["n"]) and $_GET["n"] > 0) ? $_GET["n"] : 4;

	for ($i = 1; $i < $n; $i++) {
		echo $i * $i . ",";
	}
	echo $n * $n;

	$url = "http://$_SERVER[HTTP_HOST]/niz.php?n=";

	echo "<br><a href='$url" . ($n + 1) . "'>Uvećaj</a>";
	echo "<br><a href='$url" . ($n - 1) . "'>Umanji</a>";
