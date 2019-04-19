<?php
/* 
$a = 1;
$b = &$a;
$c = $a;

$b = 2;

echo $a, $b, $c, PHP_EOL;
 */
/* 
$a = 10;
$c = 20;
$ref = &$a;
$ref = &$c;
$ref = 30;

echo $a, PHP_EOL;
echo $c, PHP_EOL;
 */
function array_pass($array)
{
    $array[0] *= 2;
    $array[1] *= 2;
}

function array_pass_ref(&$array)
{
    $array[0] *= 2;
    $array[1] *= 2;
}
/* 
$a = 10;
$b = 20;

$array = array($a, &$b);
array_pass($array);

echo $a, PHP_EOL;
echo $b, PHP_EOL;
 */
/* 
$a = 10;
$b = 20;

$array = array($a, $b);
array_pass_ref($array);

echo $a, PHP_EOL;
echo $b, PHP_EOL;
var_dump($array);
 */
