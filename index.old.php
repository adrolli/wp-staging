<?php

/* *** WordPress Stage Manager *** */
/* ****** by Alf Drollinger ****** */
/* ***** alf@drollinger.info ***** */

/* TODO
feather?
matomo
live-DB: d034dcf5:L7awkUC5z4Xa9
*/

// Configuration
$username = "admin@local.de";
$password = "1154";
$platforms = [
    "live" => [
        "name"  => "Live-Platform",
        "prot"  => "https",
        "url"   => "www.meinsolarstrom.de",
        "path"  => "meinsolarstrom.de/",
    ],
    "next" => [
        "name"  => "Next-Platform",
        "prot"  => "https",
        "url"   => "next.meinsolarstrom.de",
        "path"  => "next.meinsolarstrom.de/",
    ],
    "last" => [
        "name"  => "Last-Platform",
        "prot"  => "https",
        "url"   => "last.meinsolarstrom.de",
        "path"  => "last.meinsolarstrom.de/",
    ],
];
$stages_relpath = "../";
$backup_path = "backup/";

// Login and Session
session_start();
$errorMsg = "";
$validUser = $_SESSION["login"] === true;
if(isset($_POST["sub"])) {
  $validUser = $_POST["username"] == $username && $_POST["password"] == $password;
  if(!$validUser) $errorMsg = '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
  else $_SESSION["login"] = true;
}

// Logout
if(isset($_POST["out"])) {
    session_destroy();
    header('Location: '.$_SERVER['PHP_SELF']);
}

// Read DB-creds from wp-config.php
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

// Dump a mysql-table to dump.sql
function backupMysql($platform, $platforms, $stages_relpath) {

    $platformpath = $stages_relpath . $platforms[$platform]['path'];
    $wpconfig = $platformpath . "wp-config.php";
    $dbconn = getDatabaseFromConfig($wpconfig);
    $sqlfile = $platformpath . "dump.sql";

    $command='mysqldump --opt -h' .$dbconn["host"] .' -u' .$dbconn["user"] .' -p' .$dbconn["pass"] .' ' .$dbconn["name"] .' > ' . $sqlfile;
    exec($command,$output=array(),$worked);
    switch($worked){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully stored in the following path '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when exporting ' . $dbconn["name"] .' to '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 2:
        $error = '<div class="alert alert-danger" role="alert">An export error has occurred, please check the connection to ' . $dbconn["name"] . ' using user ' . $dbconn["user"] . ' on host ' . $dbconn["host"] . '.</div>';
    break;
    }
    return array($success,$error);
}

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

// Search and replace url and path in sql-file
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

// Copy a platform-folder
function copyPlatformFolder($platform, $target_platform, $platforms, $stages_relpath) {

    $platformpath = $stages_relpath . $platforms[$platform]['path'];
    $wpconfig = $platformpath . "wp-config.php";

    $targetpath = $stages_relpath . $platforms[$target_platform]['path'];
    $wptarget = $targetpath . "wp-config.php";

    $wptemp = "wp-config.php";

    if (!copy($wpconfig, $wptemp)) {
        $error = "Failed to copy $wpconfig to $wptemp!";
    } else {
        $success = "Copied $wpconfig to $wptemp successfully.";
    }

    $command='rm -f ' . $targetpath;
    exec($command,$output=array(),$worked);
    switch($worked){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully restored from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when importing to ' . $dbconn["name"] .' from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    }

    $command2='cp -Rf ' . $platformpath . ' ' . $targetpath;
    exec($command2,$output=array(),$worked2);
    switch($worked2){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully restored from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when importing to ' . $dbconn["name"] .' from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    }

    if (!copy($wptemp, $wptarget)) {
        $error = "Failed to copy $wptemp to $wptarget!";
    } else {
        $success = "Copied $wptemp to $wptarget successfully.";
    }

    return array($success,$error);
}

// Pump the SQL-file into database
function restoreMysql($platform, $platforms, $stages_relpath) {

    $platformpath = $stages_relpath . $platforms[$platform]['path'];
    $wpconfig = $platformpath . "wp-config.php";
    $dbconn = getDatabaseFromConfig($wpconfig);
    $sqlfile = $platformpath . "dump.sql";

    $command='mysql -h' .$dbconn["host"] .' -u' .$dbconn["user"] .' -p' .$dbconn["pass"] .' ' .$dbconn["name"] .' < ' . $sqlfile;
    exec($command,$output=array(),$worked);
    switch($worked){
    case 0:
        $success = '<div class="alert alert-success" role="alert">The database ' . $dbconn["name"] .' was successfully restored from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 1:
        $error = '<div class="alert alert-danger" role="alert">An error occurred when importing to ' . $dbconn["name"] .' from '.getcwd().'/' . $sqlfile .'.</div>';
    break;
    case 2:
        $error = '<div class="alert alert-danger" role="alert">An export error has occurred, please check the connection to ' . $dbconn["name"] . ' using user ' . $dbconn["user"] . ' on host ' . $dbconn["host"] . '.</div>';
    break;
    }
    return array($success,$error);
}

// Backup a plattform incl. SQL-file
function backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path) {
    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = backupPlatform($platform, $platforms, $stages_relpath, $backup_path);
    return array($success,$error);
}

// Copy to another stage
function copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path) {
    list($success,$error) = backupMysql($platform, $platforms, $stages_relpath);
    list($success,$error) = backupPlatformWithDb($platform, $platforms, $stages_relpath, $backup_path);
    list($success,$error) = copyPlatformFolder($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = replaceInSqlFile($platform, $target_platform, $platforms, $stages_relpath);
    //list($success,$error) = restoreMysql($target_platform, $platforms, $stages_relpath);
    return array($success,$error);
}

$platform = "next";
$target_platform = "live";
//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);

//list($success,$error) = copyStage($platform, $target_platform, $platforms, $stages_relpath, $backup_path);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WordPress Stage Manager</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<?php


if($validUser) {

    ?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      body {
        font-size: .875rem;
        }

        .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
        }

        /*
        * Sidebar
        */

        .sidebar {
        position: fixed;
        top: 0;
        /* rtl:raw:
        right: 0;
        */
        bottom: 0;
        /* rtl:remove */
        left: 0;
        z-index: 100; /* Behind the navbar */
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        @media (max-width: 767.98px) {
        .sidebar {
            top: 5rem;
        }
        }

        .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }

        .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        }

        .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #727272;
        }

        .sidebar .nav-link.active {
        color: #007bff;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
        color: inherit;
        }

        .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
        }

        /*
        * Navbar
        */

        .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        background-color: rgba(0, 0, 0, .25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .navbar-toggler {
        top: .25rem;
        right: 1rem;
        }

        .navbar .form-control {
        padding: .75rem 1rem;
        border-width: 0;
        border-radius: 0;
        }

        .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }

    </style>
    
  </head>
  <body>
        
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">WordPress Stage Manager</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form name="logout" action="" method="post">

            <button class="btn btn-large" style="color: white;" type="submit" name="out">Sign out</button>

            </form>
        </li>
    </ul>
    </header>

    <div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                <span data-feather="home"></span>
                Platforms
                </a>
            </li>
            </ul>
        </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Platforms</h1>
        </div>

        <?php 
        
        echo $success . $error;

        foreach ($platforms as $platform => $value) {

            echo '
            <div class="card mb-3" style="max-width: 800px;">
            <div class="row g-0">
              <div class="col-md-5" style="max-height: 200px;">
                <iframe style="left: 28px;
                  top: 38px;
                  width: 1600px;
                  height: 992px;
                  transform: scale(0.2);
                  -webkit-transform: scale(0.2);
                  -o-transform: scale(0.2);
                  -ms-transform: scale(0.2);
                  -moz-transform: scale(0.2);
                  transform-origin: top left;
                  -webkit-transform-origin: top left;
                  -o-transform-origin: top left;
                  -ms-transform-origin: top left;
                  -moz-transform-origin: top left;" src=' . $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] . '></iframe>
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title">' . $platforms[$platform]['name'] . '</h5>
                  <p class="card-text"><small class="text-muted">' . $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] . ' (Robots-Status: Unknown)</small></p>
                  <div class="d-flex">
                    <p class="card-text"><a class="btn btn-sm btn-primary me-2" href="' . $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] . '" target="_blank">WordPress Website</a></p>
                    <p class="card-text"><a class="btn btn-sm btn-secondary me-2" href="' . $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] . '/wp-admin" target="_blank">WordPress Admin</a></p>
                  </div>
                  <div class="d-flex">
                      <form>
                        <button class="btn btn-sm btn-danger me-2">Locked</button>
                      </form>
                      <form>
                        <button class="btn btn-sm btn-success me-2">Backup</button>
                      </form>
                      <form>
                        <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Stage to
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                        $this_platform = $platforms[$platform]['name'];
                        foreach ($platforms as $platform => $value) {
                            if ($this_platform != $platforms[$platform]['name']) {
                                echo '<li><a class="dropdown-item" href="#">' . $platforms[$platform]['name'] . '</a></li>';
                            }
                        }
                        echo '</ul>
                      </div>

                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>';
        }
        ?>

        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>


    <?php

} else {

    ?>

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
            html,
            body {
            height: 100%;
            }
            body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
            }

            .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
            }
            .form-signin .checkbox {
            font-weight: 400;
            }
            .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
            }
            .form-signin .form-control:focus {
            z-index: 2;
            }
            .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            }
        </style>

    </head>
    <body class="text-center">

        <main class="form-signin">

            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px"
                height="61px" viewBox="0 0 540 122.523" enable-background="new 0 0 540 122.523" xml:space="preserve">
            <g id="Layer_1">
            </g>
            <g id="Layer_2">
                <g>
                    <path fill="#00749A" d="M313.19,48.227h-21.257v2.255c6.649,0,7.718,1.425,7.718,9.857V75.54c0,8.431-1.068,9.975-7.718,9.975
                        c-5.105-0.712-8.55-3.444-13.3-8.669l-5.462-5.937c7.362-1.308,11.28-5.938,11.28-11.164c0-6.53-5.58-11.518-16.031-11.518h-20.9
                        v2.255c6.649,0,7.718,1.425,7.718,9.857V75.54c0,8.431-1.069,9.975-7.718,9.975v2.256h23.631v-2.256
                        c-6.649,0-7.718-1.544-7.718-9.975v-4.274h2.018l13.182,16.505h34.557c16.981,0,24.344-9.024,24.344-19.832
                        C337.534,57.133,330.172,48.227,313.19,48.227z M263.434,67.582V51.79h4.868c5.343,0,7.719,3.681,7.719,7.956
                        c0,4.157-2.376,7.837-7.719,7.837H263.434z M313.547,84.09h-0.832c-4.274,0-4.868-1.068-4.868-6.531V51.79c0,0,5.225,0,5.7,0
                        c12.35,0,14.605,9.024,14.605,16.031C328.152,75.064,325.896,84.09,313.547,84.09z"/>
                    <path fill="#00749A" d="M181.378,71.978l8.194-24.227c2.376-7.006,1.307-9.024-6.293-9.024v-2.376h22.325v2.376
                        c-7.481,0-9.262,1.781-12.231,10.45L179.834,89.79h-1.543l-12.114-37.17l-12.349,37.17h-1.544l-13.181-40.613
                        c-2.85-8.669-4.75-10.45-11.638-10.45v-2.376h26.363v2.376c-7.007,0-8.908,1.662-6.413,9.024l7.956,24.227l11.994-35.627h2.257
                        L181.378,71.978z"/>
                    <path fill="#00749A" d="M221.752,89.314c-13.062,0-23.75-9.618-23.75-21.376c0-11.637,10.689-21.257,23.75-21.257
                        c13.063,0,23.75,9.62,23.75,21.257C245.502,79.696,234.815,89.314,221.752,89.314z M221.752,50.365
                        c-10.924,0-14.725,9.855-14.725,17.574c0,7.839,3.801,17.576,14.725,17.576c11.045,0,14.845-9.737,14.845-17.576
                        C236.597,60.22,232.797,50.365,221.752,50.365z"/>
                    <path fill="#464342" d="M366.864,85.396v2.375H339.67v-2.375c7.957,0,9.382-2.018,9.382-13.895V52.502
                        c0-11.877-1.425-13.776-9.382-13.776v-2.376h24.581c12.231,0,19.002,6.294,19.002,14.727c0,8.194-6.771,14.606-19.002,14.606
                        h-6.769v5.817C357.482,83.378,358.907,85.396,366.864,85.396z M364.251,40.625h-6.769v20.664h6.769
                        c6.651,0,9.738-4.631,9.738-10.212C373.989,45.377,370.902,40.625,364.251,40.625z"/>
                    <path fill="#464342" d="M464.833,76.609l-0.594,2.137c-1.068,3.919-2.376,5.344-10.807,5.344h-1.663
                        c-6.174,0-7.243-1.425-7.243-9.856v-5.462c9.263,0,9.976,0.83,9.976,7.006h2.256V58.083h-2.256c0,6.175-0.713,7.006-9.976,7.006
                        V51.79h6.53c8.433,0,9.738,1.425,10.807,5.344l0.595,2.255h1.899l-0.83-11.162h-34.914v2.255c6.649,0,7.719,1.425,7.719,9.857
                        V75.54c0,7.713-0.908,9.656-6.151,9.933c-4.983-0.761-8.404-3.479-13.085-8.627l-5.463-5.937
                        c7.363-1.308,11.282-5.938,11.282-11.164c0-6.53-5.581-11.518-16.031-11.518h-20.9v2.255c6.649,0,7.718,1.425,7.718,9.857V75.54
                        c0,8.431-1.068,9.975-7.718,9.975v2.256h23.632v-2.256c-6.649,0-7.719-1.544-7.719-9.975v-4.274h2.019l13.181,16.505h48.806
                        l0.713-11.161H464.833z M401.896,67.582V51.79h4.868c5.344,0,7.72,3.681,7.72,7.956c0,4.157-2.376,7.837-7.72,7.837H401.896z"/>
                    <path fill="#464342" d="M488.939,89.314c-4.75,0-8.907-2.493-10.688-4.038c-0.594,0.595-1.662,2.376-1.899,4.038h-2.257V72.928
                        h2.375c0.951,7.837,6.412,12.468,13.419,12.468c3.8,0,6.888-2.137,6.888-5.699c0-3.087-2.731-5.463-7.6-7.719l-6.769-3.206
                        c-4.751-2.258-8.313-6.177-8.313-11.401c0-5.7,5.344-10.568,12.707-10.568c3.919,0,7.243,1.425,9.263,3.087
                        c0.593-0.475,1.187-1.782,1.544-3.208h2.256v14.014h-2.494c-0.832-5.582-3.919-10.213-10.212-10.213
                        c-3.325,0-6.414,1.9-6.414,4.87c0,3.087,2.494,4.749,8.195,7.362l6.53,3.206c5.701,2.731,7.956,7.127,7.956,10.689
                        C503.426,84.09,496.895,89.314,488.939,89.314z"/>
                    <path fill="#464342" d="M525.514,89.314c-4.751,0-8.908-2.493-10.688-4.038c-0.594,0.595-1.662,2.376-1.899,4.038h-2.257V72.928
                        h2.375c0.95,7.837,6.412,12.468,13.419,12.468c3.8,0,6.888-2.137,6.888-5.699c0-3.087-2.731-5.463-7.601-7.719l-6.769-3.206
                        c-4.75-2.258-8.313-6.177-8.313-11.401c0-5.7,5.344-10.568,12.707-10.568c3.919,0,7.243,1.425,9.263,3.087
                        c0.593-0.475,1.187-1.782,1.542-3.208h2.257v14.014h-2.493c-0.832-5.582-3.919-10.213-10.212-10.213
                        c-3.325,0-6.414,1.9-6.414,4.87c0,3.087,2.494,4.749,8.195,7.362l6.53,3.206c5.701,2.731,7.956,7.127,7.956,10.689
                        C540,84.09,533.469,89.314,525.514,89.314z"/>
                    <g>
                        <path fill="#464342" d="M8.708,61.26c0,20.802,12.089,38.779,29.619,47.298L13.258,39.872
                            C10.342,46.408,8.708,53.641,8.708,61.26z"/>
                        <path fill="#464342" d="M96.74,58.608c0-6.495-2.333-10.993-4.334-14.494c-2.664-4.329-5.161-7.995-5.161-12.324
                            c0-4.831,3.664-9.328,8.825-9.328c0.233,0,0.454,0.029,0.681,0.042c-9.35-8.566-21.807-13.796-35.489-13.796
                            c-18.36,0-34.513,9.42-43.91,23.688c1.233,0.037,2.395,0.063,3.382,0.063c5.497,0,14.006-0.667,14.006-0.667
                            c2.833-0.167,3.167,3.994,0.337,4.329c0,0-2.847,0.335-6.015,0.501L48.2,93.547l11.501-34.493l-8.188-22.434
                            c-2.83-0.166-5.511-0.501-5.511-0.501c-2.832-0.166-2.5-4.496,0.332-4.329c0,0,8.679,0.667,13.843,0.667
                            c5.496,0,14.006-0.667,14.006-0.667c2.835-0.167,3.168,3.994,0.337,4.329c0,0-2.853,0.335-6.015,0.501l18.992,56.494
                            l5.242-17.517C95.011,68.328,96.74,63.107,96.74,58.608z"/>
                        <path fill="#464342" d="M62.184,65.857l-15.768,45.819c4.708,1.384,9.687,2.141,14.846,2.141c6.12,0,11.989-1.058,17.452-2.979
                            c-0.141-0.225-0.269-0.464-0.374-0.724L62.184,65.857z"/>
                       <path fill="#464342" d="M107.376,36.046c0.226,1.674,0.354,3.471,0.354,5.404c0,5.333-0.996,11.328-3.996,18.824l-16.053,46.413
                            c15.624-9.111,26.133-26.038,26.133-45.426C113.815,52.124,111.481,43.532,107.376,36.046z"/>
                        <path fill="#464342" d="M61.262,0C27.483,0,0,27.481,0,61.26c0,33.783,27.483,61.263,61.262,61.263
                            c33.778,0,61.265-27.48,61.265-61.263C122.526,27.481,95.04,0,61.262,0z M61.262,119.715c-32.23,0-58.453-26.223-58.453-58.455
                            c0-32.23,26.222-58.451,58.453-58.451c32.229,0,58.45,26.221,58.45,58.451C119.712,93.492,93.491,119.715,61.262,119.715z"/>
                    </g>
                </g>
            </g>
            </svg>

            <form name="input" action="" method="post">

                <h1 class="h3 mb-3 fw-normal mt-3">Stage Manager</h1>

                <?= $errorMsg ?>
                <label for="username" class="visually-hidden">Email address</label>
                <input type="email" id="username" name="username" class="form-control" placeholder="Email address" required autofocus>
                <label for="password" class="visually-hidden">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="sub">Sign in</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2020 Alf Drollinger</p>
            </form>
        </main>

    <?php

}
?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>