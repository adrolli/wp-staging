<?php

/* 
 * Footer with copyright
 * 
 */

?>

<footer>
    <p class="mt-5 mb-3 text-muted">&copy; 2020 <a href="https://alf-drollinger.com">Alf Drollinger</a></p>
</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<?php echo '<script src="assets/js/'.($validUser ? 'app' : 'login').'.js"></script>'; ?>

</body>
</html>