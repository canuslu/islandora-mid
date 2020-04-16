// JS file for islandora-book-page.tpl.php
var $ = jQuery;
$(document).ready(function() {
    function resizePage() {
        var windowHeight = $(window).height();
        var toolbarHeight = $("#toolbar").height();
        var navbarHeight = $("#navbar").height();
        var breadcrumbHeight = $(".breadcrumb").height();

        var pageHeight = windowHeight - (toolbarHeight + navbarHeight + breadcrumbHeight);
        $("#islandora-openseadragon").height(pageHeight);
    }

    resizePage();

    $(window).on('resize', function() {
        resizePage();
    });

    $(".tabs--primary a:contains('Manage')").appendTo("#manage-link");

    $("#menu-left li").click(function() {
        if ($(this).hasClass("click-redirect")) {
            console.log("Redirecting...");
        } else {
            target_div = $(this).attr('href');
            $(".menu-left-detail-item").hide();
            if ($(".menu-left-detail").is(":hidden")) {
                $(".menu-left-detail").show();
            }
            $(target_div).show();
        }
    });

    $("#close-menu-left-detail").click(function() {
        $(".menu-left-detail").hide();
    });

});
