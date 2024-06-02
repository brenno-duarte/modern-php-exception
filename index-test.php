<?php

require 'vendor/autoload.php';

use Test\UserTest;
use ModernPHPException\ModernPHPException;

//$config = __DIR__ . '/config.example.yaml';
$config = "";
$exc = new ModernPHPException($config);
#$exc->enableOccurrences();
$exc->start();

#http_response_code(404);

#echo '<pre>';

//throw new Exception("Error Processing Request");

/* trigger_error("Test", E_USER_WARNING);
echo "After trigger_error"; */

//UserTest::staticCall();

/* function dividir($x, $y) {
    if ($y == 0) {
        throw new \Exception('é uma divisão por zero.');
    }
    $resultado = $x / $y;
    return $resultado;
};

try {
    echo dividir(5,0)."<br/>";
} catch (\Exception $e) {
    $exc->exceptionHandler($e);
    //echo $e->getMessage();
} */

/* try {
    echo $a;
} catch (\Exception $e) {
    $exc->exceptionHandler($e);
} */

/* $a = (new UserTest())->secondCall();

var_dump_debug($a, true); */

//echo $a;

//$a = new FakeClass(); //FATAL ERROR

(new UserTest())->triggerTest();