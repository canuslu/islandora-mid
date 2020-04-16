// JS file for islandora-newspaper-page.tpl.php
var $ = jQuery;
$(document).ready(function () {

    function resizePage() {
        var windowHeight = $(window).height();
        var toolbarHeight = $("#toolbar").height();
        var navbarHeight = $("#navbar").height();
        var breadcrumbHeight = $(".breadcrumb").height();

        var pageHeight = windowHeight - (toolbarHeight + navbarHeight + breadcrumbHeight);
        $("#islandora-openseadragon").height(pageHeight);
    }

    resizePage();

    $(window).on('resize', function(){
        resizePage();
    });
});
