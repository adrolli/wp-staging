<?php

/* 
 * Copy platform-folder
 * 
 */

function copyPlatformFolder($platform, $target_platform, $platforms, $stages_relpath) {

    $platformpath = $stages_relpath . $platforms[$platform]['path'];
    $wpconfig = $platformpath . "wp-config.php";

    $targetpath = $stages_relpath . $platforms[$target_platform]['path'];
    $wptarget = $targetpath . "wp-config.php";

    $wptemp = "wp-config.php";

    if (!copy($wpconfig, $wptemp)) {
        $error = "Failed to copy $wpconfig to $wptemp!";
    } else {
        $success = "Copied $wpconfig to $wptemp successfully.";
    }

    $command='rm -f ' . $targetpath;
    exec($command,$output=array(),$worked);
    switch($worked){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully restored from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when importing to ' . $dbconn["name"] .' from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    }

    $command2='cp -Rf ' . $platformpath . ' ' . $targetpath;
    exec($command2,$output=array(),$worked2);
    switch($worked2){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully restored from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when importing to ' . $dbconn["name"] .' from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    }

    if (!copy($wptemp, $wptarget)) {
        $error = "Failed to copy $wptemp to $wptarget!";
    } else {
        $success = "Copied $wptemp to $wptarget successfully.";
    }

    return array($success,$error);
}