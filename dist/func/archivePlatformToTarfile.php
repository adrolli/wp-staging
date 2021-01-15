<?php

// Backup a platform to tar.gz-Archive
function backupPlatform($platform, $platforms, $stages_relpath, $backup_path) {

    $dir_path = $stages_relpath . $platforms[$platform]['path'];
    $archive_name = $backup_path . $platform . "_backup.tar";

    if (Phar::canCompress()) {
        $archive = new PharData($archive_name);
        $archive->buildFromDirectory($dir_path);
        $archive->compress(Phar::GZ);
        unlink($archive_name);
        $success = "Archive " . $archive_name . " created from folder " . $dir_path . ".";
    } else {
        $error = 'Archive could not be created. No compression available.';
    }
    return array($success,$error);
}