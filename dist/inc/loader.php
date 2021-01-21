<?php

/* 
 * Autoload functions and taskruns
 * 
 */

foreach (glob("func/*.php") as $function)
{
    include $function;
}