<?php

$username = "admin@local.test";
$password = "password";
$platforms = [
    "live" => [
        "name"  => "Live",
        "prot"  => "https",
        "url"   => "www.test.local",
        "path"  => "www/",
    ],
    "dev" => [
        "name"  => "Dev",
        "prot"  => "https",
        "url"   => "dev.test.local",
        "path"  => "dev/",
    ],
    "last" => [
        "name"  => "Backup",
        "prot"  => "https",
        "url"   => "last.test.local",
        "path"  => "last/",
    ],
];
$stages_relpath = "../";
$backup_path = "backup/";
