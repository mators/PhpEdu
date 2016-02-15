<?php
$originalString = "Abecedanejdedozjerimaž";

$untilz = substr($originalString, 0, stripos($originalString, "z"));
$lowerString = mb_strtolower($untilz, 'UTF-8');
$counted = count_chars($lowerString, 0);

echo $counted[ord("a")] + $counted[ord("b")] + $counted[ord("c")];
