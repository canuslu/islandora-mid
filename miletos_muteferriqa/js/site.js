// Site-wide applicable JS codes.
var $ = jQuery;

$(document).ready(function() {

    function resizeAutocomplete() {
        var tWidth = $("#edit-islandora-simple-search-query").width();
        $("#ui-id-1").css('width', tWidth + "px");
    }

    resizeAutocomplete();

    $(window).on('resize', function() {
        resizeAutocomplete();
    });

    function moreThanThree(input) {
        if (input.val().length >= 3 || input.val().length == 0) {
            return true;
        } else {
            return false;
        }
    }

    var searchBoxes = ["edit-islandora-simple-search-query", "textSrch"];
    $("input").on("change paste keyup", function() {
        var target = $(this).attr("id");
        var button2disable = $(this).parent().parent().find("button");
        if (searchBoxes.includes(target)) {
            if (moreThanThree($(this))) {
                button2disable.attr("disabled", false);
            } else {
                button2disable.attr("disabled", true);
            }
        }
    });

    window.keyboardTrigger = function(input) {
        $("#on-screen-keyboard").show();
        lastActiveInput = input.parent().find("input")[0];
        $(lastActiveInput).focus();
    }

    $("#on-screen-keyboard-close").click(function() {
        $("#on-screen-keyboard").hide();
    });

    $("#ota-keyboard-delete").click(function(event) {
        lastActiveInput.value = lastActiveInput.value.slice(0, -1);
    });

    $("#ota-keyboard-trash").click(function(event) {
        lastActiveInput.value = "";
    });

    // Advanced Search - virtual keyboard
    var lastActiveInput;

    var faker = jQuery.Event("keydown");
    faker.which = 77; // m code value
    faker.altKey = true; // Alt key pressed

    $("#on-screen-keyboard .character").click(function() {
        targetInput = $(lastActiveInput);
        targetInput.val(targetInput.val() + $(this).attr("value"));
        targetInput.attr("tabindex", -1).focus().change().trigger(faker);
    });

    $("#tooltip-indicator").hover(function() {
        $("#on-screen-keyboard").css("background-color", "#2196f3");
        $("#tooltip-indicator .fa-arrows-alt").css("color", "white");
    }, function() {
        $("#on-screen-keyboard").css("background-color", "white");
        $("#tooltip-indicator .fa-arrows-alt").css("color", "#2196f3");
    });

    $("#on-screen-keyboard").draggable();
    $("#tooltip-indicator").tooltip();

});
