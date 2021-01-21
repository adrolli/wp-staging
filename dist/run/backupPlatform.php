<?php

/* 
 * Backup platform incl. SQL-dump to tar.gz archive
 * 
 */

ob_implicit_flush(true);
ob_end_flush();

include("../config.php");
include("../func/archivePlatformToTarfile.php");
include("../func/displayToastMessage.php");

displayToastMessage("primary","Info", "Starting Backup ...");

function backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path) {

    //list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = archivePlatformToTarfile($platform, $platforms, $stages_relpath, $backup_path);


    return array($success,$error);
}



list($success,$error) = backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path);

$sourcePlatform = $_POST['platform'];
$error = "Backup from " . $sourcePlatform;

displayToastMessage("danger","Error", $error);
displayToastMessage("success","Success", $success);
