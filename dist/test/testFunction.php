<?php

// This is a test function

function Testfunc($platform) {
    sleep(5);
    echo "Test Echo " . $platform;
    return "Test Return" . $platform;
}

$testf = Testfunc($_POST['platform']);
echo $testf;

// this should return a toast message then