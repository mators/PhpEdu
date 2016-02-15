<?php

function strReplace($trazi, $zamijeniSa, $string) {
	$len = strlen($trazi);
	while (true) {
		$index = strpos($string, $trazi);
		if ($index === false) {
			break;
		}
		$string = substr($string, 0, $index) . $zamijeniSa . substr($string, $index + $len);
	}
	return $string;
}

$string = "Ovo je neki string nad kojim cu napraviti neku zamjenu.";
$trazi = "nek";
$zamijeniSa = "X";


$ugradena = str_replace($trazi, $zamijeniSa, $string);
$moja = strReplace($trazi, $zamijeniSa, $string);


echo $string . "<br>";
echo $ugradena . "<br>";
echo $moja;

