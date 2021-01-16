<?php

/* 
 * Read DB-creds from wp-config.php
 * 
 */

function getDatabaseFromConfig($path) {
    require_once($path);
    $dbconn = [
        "name" => DB_NAME,
        "user" => DB_USER,
        "pass" => DB_PASSWORD,
        "host" => DB_HOST,
    ];
    return $dbconn;
}