<?php

class ZeroDivisionException extends Exception
{ }

function div($v1, $v2)
{
    if ($v2 === 0) {
        throw new ZeroDivisionException("arg #2 is zero.");
    }
    return $v1 / $v2;
}

try {
    echo div(1, 2), PHP_EOL;
    echo div(1, 0), PHP_EOL;
    echo div(2, 1), PHP_EOL;
} catch (ZeroDivisionException $e) {
    echo 'Zero Division Exception!', PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

try {
    array_merge();
} catch (ErrorException $e) {
    echo 'Error occured!', PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
    echo 'Stack Trace:', PHP_EOL;
    echo $e->getTraceAsString();
}
