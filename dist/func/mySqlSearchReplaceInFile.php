<?php

/* 
 * Search and replace (e. g. url and path) in sql-file
 * 
 */

function replaceInSqlFile($platform, $target_platform, $platforms, $stages_relpath) {

    $path_to_file = $stages_relpath . $platforms[$platform]['path'] . "dump.sql";

    $source_url = $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'];
    $target_url = $platforms[$target_platform]['prot'] . "://" . $platforms[$target_platform]['url'];

    $source_path = $platforms[$platform]['path'];
    $target_path = $platforms[$target_platform]['path'];            

    if (file_exists($path_to_file)) {
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace($source_url,$target_url,$file_contents);
        $file_contents = str_replace($source_path,$target_path,$file_contents);
        file_put_contents($path_to_file,$file_contents);
        $success = "Changed SQL-Contents in file $path_to_file from $source_url to $target_url.";
    } else {
        $error = "File $path_to_file not found.";
    }
    return array($success,$error);
}