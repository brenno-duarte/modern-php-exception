<?php

require 'vendor/autoload.php';

use Test\UserTest;
use ModernPHPException\ModernPHPException;

$config = __DIR__ . '/config.example.yaml';
//$config = "";
$exc = new ModernPHPException($config);
//$exc->enableOccurrences();
//$exc->ignoreErrors([E_USER_DEPRECATED, E_WARNING]);
$exc->start();

//http_response_code(404);
#echo '<pre>';

//throw new Exception("<script>alert('test from JS')</script>");

/* trigger_error("Test trigger", E_USER_DEPRECATED);
echo "After trigger function"; */

UserTest::staticCall();

/* function dividir($x, $y) {
    if ($y == 0) {
        throw new \Exception('é uma divisão por zero.');
    }
    $resultado = $x / $y;
    return $resultado;
};

try {
    echo dividir(5,3);
    echo get_debug_backtrace();
} catch (\Exception $e) {
    $exc->exceptionHandler($e);
    //echo $e->getMessage();
} */

/* $a = (new UserTest())->secondCall();
var_dump_debug($a, true); */

//echo $a;

//$a = new FakeClass(); //FATAL ERROR
//(new UserTest())->triggerTest();