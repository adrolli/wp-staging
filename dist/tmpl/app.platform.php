<?php

/* 
 * Render the platform page
 * 
 */

?>

 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Platforms</h1>
        </div>

        <?php 
        
        echo $success . $error;

        foreach ($platforms as $platform => $value) {

            include("partial/card.platform.php");

        }
        
        ?>

        </main>
    </div>
    </div>