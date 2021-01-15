<?php

// Logout
if(isset($_POST["out"])) {
    session_destroy();
    header('Location: '.$_SERVER['PHP_SELF']);
}