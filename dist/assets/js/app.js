$(document).ready(function() {

    runs.forEach(handleAjaxRequest);

    function handleAjaxRequest(run) {

        if (run.startsWith("backup-")) {
            var script = "backupPlatform";
        } else if (run.startsWith("delete-")) {
            var script = "deletePlatform";
        } else if (run.startsWith("restore-")) {
            var script = "restorePlatform";
        } else if (run.startsWith("secure-")) {
            var script = "securePlatform";
        } else if (run.startsWith("stage-")) {
            var script = "stagePlatform";
        } else {
            var script = run;
        }

        var request;
        $("#" + run).submit(function(event){
            event.preventDefault();
            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            $inputs.prop("disabled", true);
            request = $.ajax({
                url: "run/" + script + ".php",
                type: "post",
                data: serializedData
            });
            request.done(function (response, textStatus, jqXHR){
                //console.log("Response: " + response);
                $('#toast-container').html(response);
                $(".toast").toast('show');
            });
            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });
            request.always(function () {
                $inputs.prop("disabled", false);
            });
        });
    
    }

});