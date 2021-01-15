<?php

// Copy to another stage
function copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path) {
    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path);
    list($success,$error) = copyPlatformFolder($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = replaceInSqlFile($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = restoreMysql($target_platform, $platforms, $stages_relpath);
    return array($success,$error);
}