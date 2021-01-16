<?php

/* 
 * Example configuration
 * Copy this file or rename to config.php
 * 
 */

// username for login, must be a valid mailaddress
$username = "admin@local.test";
// password for login
$password = "password";
// define platforms to manage
// avail. types: wp; matomo
// login is optional for autologin
$platforms = [
    "live" => [
        "type"  => "wp",
        "name"  => "Live",
        "prot"  => "https",
        "url"   => "www.test.local",
        "path"  => "www/",
        "login" => [
            "urlpath"   => "/wp-login.php",
            "method"    => "POST",
            "user"      => "admin",
            "pass"      => "password",
        ],
    ],
    "dev" => [
        "type"  => "wp",
        "name"  => "Dev",
        "prot"  => "https",
        "url"   => "dev.test.local",
        "path"  => "dev/",
        "login" => [
            "urlpath"   => "/wp-login.php",
            "method"    => "POST",
            "user"      => "admin",
            "pass"      => "password",
        ],
    ],
    "last" => [
        "type"  => "wp",
        "name"  => "Backup",
        "prot"  => "https",
        "url"   => "last.test.local",
        "path"  => "last/",
        "login" => [
            "urlpath"   => "/wp-login.php",
            "method"    => "POST",
            "user"      => "admin",
            "pass"      => "password",
        ],
    ],
];
// where are the stages rel to app
$stages_relpath = "../";
// where should backups be store rel to app
$backup_path = "backup/";
