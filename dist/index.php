<?php

include("config.php");
include("inc/login.inc.php");
include("inc/logout.inc.php");
include("tmpl/header.php");

if($validUser) {

    include("tmpl/app.main.php");

} else {
    include("tmpl/login.php");
}

include("tmpl/footer.php");