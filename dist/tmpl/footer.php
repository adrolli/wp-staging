<?php

/* 
 * Footer with copyright
 * 
 */

?>

<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
  <div class="toast" style="position: absolute; top: 0; right: 0;">
    <div class="toast-header">
      <img src="..." class="rounded mr-2" alt="...">
      <strong class="mr-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>

<footer>
    <p class="mt-5 mb-3 text-muted">&copy; 2020 <a href="https://alf-drollinger.com">Alf Drollinger</a></p>
</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $(".toast").toast('show');
    });
</script>

</body>
</html>