<?php

/* 
 * Backup platform, create tar.gz archive
 * 
 */

function archivePlatformToTarfile($platform, $platforms, $stages_relpath, $backup_path) {

    $dir_path = "../" . $stages_relpath . $platforms[$platform]['path'];
    $archive_name = "../" . $backup_path . $platform . "_backup.tar";

    if (Phar::canCompress()) {
        $archive = new PharData($archive_name);
        $archive->buildFromDirectory($dir_path);
        $archive->compress(Phar::GZ);
        unlink($archive_name);
        $success = "Archive " . $archive_name . " created from folder " . $dir_path . ".";
        displayToastMessage("success","Success", $success);
        echo $success;
    } else {
        $error = "Archive " . $archive_name . "  could not be created.";
        displayToastMessage("danger","Error", $error);
        echo $error;
    }
    return array($success,$error);
}