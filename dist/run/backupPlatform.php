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

sleep(5);

displayToastMessage("primary","Info", "Backup bla ...");

sleep(5);


// Backup a plattform incl. SQL-file
function backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path) {
//    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
//    list($success,$error) = archivePlatformToTarfile($platform, $platforms, $stages_relpath, $backup_path);
    $error = "hallo ballo";
    return array($success,$error);
}


/*
if(isset($_POST["backup"])) {
    $platform = $_POST["platform"];
    $success = $platform . "-backup";
}

if($_POST["mode"] == "stage") {
    $platform = $_POST["platform"];
    $target_platform = $_POST["target_platform"];
    $success = $platform . " to " . $target_platform;
}

if(isset($_GET["platform"])) {
    $platform = $_GET["platform"];
    $target_platform = $_GET["target_platform"];
    $success = $platform . " to " . $target_platform;
}
*/

list($success,$error) = backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path);

$sourcePlatform = $_POST['platform'];
$error = "Backup from " . $sourcePlatform;

displayToastMessage("danger","Error", $error);
displayToastMessage("success","Success", $error);
displayToastMessage("warning","Warning", $error);


//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);

//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);