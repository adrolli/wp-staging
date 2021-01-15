<?php

$username = "admin@local.test";
$password = "password";
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
$stages_relpath = "../";
$backup_path = "backup/";
