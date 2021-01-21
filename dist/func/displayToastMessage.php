<?php

/* 
 * Display success, warning or error-message
 * 
 */

function displayToastMessage($type, $heading, $content) {

        echo '
              <div class="toast position-relative" aria-live="assertive" aria-atomic="true" data-bs-delay="10000" data-bs-animation="true">
              <div class="toast-header">
                <div class="rounded me-2 text-white bg-' . $type .'" style="width:17px; height:17px"></div>
                <strong class="me-auto">' . $heading .'</strong>
                <small>now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
              ' . $content . '
              </div>
            </div>';
      
}
      