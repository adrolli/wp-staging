<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Test</title>
        <script src="../assets/js/jquery.min.js"></script>

    </head>
</html>
<body>
    <form id="backupPlatform" action="../run/testFunction.php" method="POST" name="backupPlatform">
        <input type="hidden" name="platform" value="live" />
        <input type="submit" value="Send" />
    </form>

    <div id="result"></div>

    <ul>
        <li>The form submits to the run-script - YEP</li>
        <li>Ajax runs the script "in the background" - YEP </li>
        <li>The script returns a bunch of messages - lets see</li>
        <li>The messages will be displayed ...?</li>
    </ul>

    <script>
        $(document).ready(function() {

            var request;
            $("#backupPlatform").submit(function(event){
                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var $form = $(this);
                var $inputs = $form.find("input, select, button, textarea");
                var serializedData = $form.serialize();
                $inputs.prop("disabled", true);
                request = $.ajax({
                    url: "../run/testFunction.php",
                    type: "post",
                    data: serializedData
                });
                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    // Log a message to the console
                    console.log("Response: " + response);
                    $('#result').html(response);
                });
                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });
                // Callback handler that will be called regardless
                // if the request failed or succeeded
                request.always(function () {
                    // Reenable the inputs
                    $inputs.prop("disabled", false);
                });
            });

        });

    </script>


</body>

</html>