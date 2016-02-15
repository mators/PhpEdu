<?php

$myImplode = function ($arr, $delimiter = "") use (&$myImplode) {
	if (empty($arr)) {
		return "";
	}
	return $arr[0] . $delimiter . $myImplode(array_splice($arr, 1));
};

$x = array("he1", "he2", "he3", "he4");
echo $myImplode($x);

