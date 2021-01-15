<?php

/* **************************************** */
/*                                          */
/*           Login and Session              */
/*                                          */
/* **************************************** */

session_start();
$errorMsg = "";
$validUser = $_SESSION["login"] === true;
if(isset($_POST["sub"])) {
  $validUser = $_POST["username"] == $username && $_POST["password"] == $password;
  if(!$validUser) $errorMsg = '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
  else $_SESSION["login"] = true;
}