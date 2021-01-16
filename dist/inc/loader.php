<?php

/* 
 * Autoload functions and taskruns
 * 
 */

foreach (glob("func/*.php") as $function)
{
    include $function;
}

foreach (glob("run/*.php") as $taskrun)
{
    include $taskrun;
}