<?php

// Backup a plattform incl. SQL-file
function backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path) {
    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = backupPlatform($platform, $platforms, $stages_relpath, $backup_path);
    return array($success,$error);
}

if(isset($_POST["backup"])) {
    $platform = $_POST["platform"];
    $success = $platform . "-backup";
}

if(isset($_GET["platform"])) {
    $platform = $_GET["platform"];
    $target_platform = $_GET["target_platform"];
    $success = $platform . " to " . $target_platform;
}
    
//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);

//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);