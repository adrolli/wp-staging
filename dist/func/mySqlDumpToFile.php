<?php

// Dump a mysql-table to dump.sql
function backupMysql($platform, $platforms, $stages_relpath) {

    $platformpath = $stages_relpath . $platforms[$platform]['path'];
    $wpconfig = $platformpath . "wp-config.php";
    $dbconn = getDatabaseFromConfig($wpconfig);
    $sqlfile = $platformpath . "dump.sql";

    $command='mysqldump --opt -h' .$dbconn["host"] .' -u' .$dbconn["user"] .' -p' .$dbconn["pass"] .' ' .$dbconn["name"] .' > ' . $sqlfile;
    exec($command,$output=array(),$worked);
    switch($worked){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully stored in the following path '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when exporting ' . $dbconn["name"] .' to '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 2:
        $error = '<div class="alert alert-danger" role="alert">An export error has occurred, please check the connection to ' . $dbconn["name"] . ' using user ' . $dbconn["user"] . ' on host ' . $dbconn["host"] . '.</div>';
    break;
    }
    return array($success,$error);
}