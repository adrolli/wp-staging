<?php

/* 
 * Partial - displays platform in card-template
 * 
 */

?>

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
                        -moz-transform-origin: top left;" src="<?php echo $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url'] ?>"></iframe>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $platforms[$platform]['name'] ?></h5>
                            <p class="card-text"><small class="text-muted"><?php echo $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url']  ?> (Robots-Status: Unknown)</small></p>
                            <div class="d-flex">
                                <p class="card-text"><a class="btn btn-sm btn-primary me-2" href="<?php echo  $platforms[$platform]['prot'] . "://" . $platforms[$platform]['url']  ?>" target="_blank">Website</a></p>
                                <form name="loginform" id="loginform" 
                                    action="<?php echo $platforms[$platform]['prot']  . '://' . $platforms[$platform]['url'] . '' . $platforms[$platform]['login']['urlpath']  ?>" 
                                    method="<?php echo $platforms[$platform]['login']['method']  ?>" target="_blank">
                                    <input type="hidden" name="log" id="user_login" class="input" value="<?php echo $platforms[$platform]['login']['user']  ?>">
                                    <input type="hidden" name="pwd" id="user_pass" class="input password-input" value="<?php echo $platforms[$platform]['login']['pass']  ?>">
                                    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-sm btn-secondary me-2" value="WordPress Admin" />
                                </form>
                            </div>
                            <div class="d-flex">
                                <form name="lock" action="" method="post">
                                    <input type="hidden" name="platform" value="<?php echo  $platform  ?>">
                                    <button class="btn btn-sm btn-danger me-2" type="submit" name="lock">Locked</button>
                                </form>
                                <form name="backup-<?php echo $platform ?>" action="" method="post" id="backup-<?php echo $platform ?>">
                                    <script>runs.push("backup-<?php echo $platform ?>");</script>
                                    <input type="hidden" name="platform" value="<?php echo $platform  ?>">
                                    <button class="btn btn-sm btn-success me-2" type="submit" name="backup">Backup</button>
                                </form>
                                <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Stage to
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php

                                            $this_platform = $platform;
                                            foreach ($platforms as $platform => $value) {
                                                if ($platforms[$this_platform]['name'] != $platforms[$platform]['name']) {
                                                    echo '<li>
                                                    <script>runs.push("stage-' . $this_platform . '-' . $platform . '");</script>
                                                    <form name="stage-' . $this_platform . '-' . $platform . '" method="post" id="stage-' . $this_platform . '-' . $platform . '">
                                                    <input type="hidden" name="sourcePlatform" value="' . $this_platform . '">                           
                                                    <input type="hidden" name="targetPlatform" value="' . $platform . '">
                                                    <button class="btn btn-sm" type="submit">' . $platforms[$platform]['name'] . '</button>
                                                    </form>
                                                    </li>';
                                                }
                                            }
                                        ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>