$(document).ready(function () {
    $("#removeDisabled").click(function() {
        $("input").removeAttr("readonly");
        $("textarea").removeAttr("readonly");
        $("select").removeAttr("disabled");
        $("button").removeAttr("hidden");
        $("#edit").remove();
    });
});