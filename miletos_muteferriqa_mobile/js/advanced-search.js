// JS file for page--node--2.tpl.php (Advanced search)
var $ = jQuery;

$(document).ready(function() {

    window.keyboardTrigger = function(input) {
        $("#on-screen-keyboard").show();
        lastActiveInput = input.siblings().find("input")[0];
        $(lastActiveInput).focus();
    }

});
