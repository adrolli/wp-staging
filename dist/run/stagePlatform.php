<?php
/* 
 * Backup platform, delete platform, restore platform and stage (search & replace) platform
 * 
 */

include("../config.php");
include("../func/archivePlatformToTarfile.php");
include("../func/displayToastMessage.php");

function copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path) {
    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path);
    list($success,$error) = copyPlatformFolder($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = replaceInSqlFile($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = restoreMysql($target_platform, $platforms, $stages_relpath);
    return array($success,$error);
}

$sourcePlatform = $_POST['sourcePlatform'];
$targetPlatform = $_POST['targetPlatform'];
$error = "Stage from " . $sourcePlatform . " to " . $targetPlatform;

displayToastMessage("danger","Error", $error);
displayToastMessage("success","Success", $error);
displayToastMessage("warning","Warning", $error);