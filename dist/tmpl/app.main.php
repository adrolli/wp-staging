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
                            <p class="card-text"><a class="btn btn-sm btn-primary me-2" href="' . $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] . '" target="_blank">Website</a></p>
                            <form name="loginform" id="loginform" action="' . $platforms[$platform]['prot'] . '://' . $platforms[$platform]['url'] . '' . $platforms[$platform]['login']['urlpath'] . '" method="' . $platforms[$platform]['login']['method'] . '" target="_blank">
                                <input type="hidden" name="log" id="user_login" class="input" value="' . $platforms[$platform]['login']['user'] . '">
                                <input type="hidden" name="pwd" id="user_pass" class="input password-input" value="' . $platforms[$platform]['login']['pass'] . '">
                                <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-sm btn-secondary me-2" value="WordPress Admin" />
                            </form>
                        </div>
                        <div class="d-flex">
                            <form name="lock" action="" method="post">
                                <input type="hidden" name="platform" value="' . $platform . '">
                                <button class="btn btn-sm btn-danger me-2" type="submit" name="lock">Locked</button>
                            </form>
                            <form name="backup" action="" method="post">
                                <input type="hidden" name="platform" value="' . $platform . '">
                                <button class="btn btn-sm btn-success me-2" type="submit" name="backup">Backup</button>
                            </form>
                            <form name="stage" action="" method="post">
                                <input type="hidden" name="platform" value="' . $platform . '">
                                <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Stage to
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                        $this_platform = $platform;
                                        foreach ($platforms as $platform => $value) {
                                            if ($platforms[$this_platform]['name'] != $platforms[$platform]['name']) {
                                                echo '<li><span class="dropdown-item" onclick="$(\'#target_platform\').val(\'' . $platform . '\'); $(\'#stage\').submit()">' . $platforms[$platform]['name'] . '</li>';
                                            }
                                        }
                                        echo '</ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>

        </main>
    </div>
    </div>