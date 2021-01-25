<?php

/* 
 * Bootstrap file
 * 
 */

include("config.php");
include("inc/login.php");
include("tmpl/header.php");

if($validUser) {

    include("inc/loader.php");
    include("tmpl/app.main.php");

} else {

    include("tmpl/login.php");

}

include("tmpl/footer.php");