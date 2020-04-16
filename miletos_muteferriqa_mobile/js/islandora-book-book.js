// JS file for islandora-book-book.tpl.php
var $ = jQuery;
$(document).ready(function() {

    $("#menu-bottom-toggler").click(function() {

        if ($("#viewer-toolbar").is(":visible")) {
            $("#menu-bottom-toggler").css({
                transform: "scaleY(1)",
                "-webkit-transform": "scaleY(1)"
            });
            $("#viewer-toolbar").hide();
        } else {
            $("#menu-bottom-toggler").css({
                transform: "scaleY(-1)",
                "-webkit-transform:": "scaleY(-1)"
            });
            $("#viewer-toolbar").show();
        }
    });

    $("#btnSrch").html('<img src="/sites/all/themes/miletos_muteferriqa/images/mim-small.png" class="submit-button-image">');

    $("#on-screen-keyboard .character").click(function() {

        var query = $("#textSrch").val();
        var button_id = $(this).attr("id");

        if (button_id == "ota-keyboard-delete") {
            $("#textSrch").val(query.substring(0, query.length - 1));
        } else if (button_id == "ota-keyboard-trash") {
            $("#textSrch").val("");
        } else {
            $("#textSrch").val(query + $(this)[0].value);
        }
    });

    $("#booksearch").submit(function() {
        $("#searchin-modal").modal("toggle");
    });

    $("#btnSrch").addClass("btn").addClass("btn-primary");

    function resizeKeyboard() {
        var keyboard_width = $("#on-screen-keyboard").width();
        var stacked_width = keyboard_width - 16;
        var char_width = stacked_width / 6;
        console.log(keyboard_width);
        console.log(stacked_width);
        console.log(char_width);
    }

    $(document).on('show.bs.modal', '#searchin-modal', function(e) {
        resizeKeyboard();
    });

    $(".book_page").click(function() {
        var bookurl = window.location;
        const regex = /#page\/(\d+)\/mode/gm;
        try {
            var pagenum = parseInt(regex.exec(bookurl)[1]);
        } catch {
            var pagenum = 1;
        }
        var ppid = Drupal.settings.islandoraInternetArchiveBookReader.pages[pagenum - 1].pid;
        $("#islandora-openseadragon").attr("pagenum", pagenum);
        prepareOSD(ppid);
    });

    var highlights = {};
    var searchPins;

    function prepareSearchPins(pagenum, nav) {

        var idx;
        searchPins = [];

        $(".search span").each(function() {
            searchPins.push($(this).text().replace(/[^\d.]/g, ''));
        });

        if (searchPins.includes(pagenum) == false) {
            searchPins.push(pagenum);
        };

        searchPins = searchPins.sort(function(a, b) {
            return a - b;
        });
        if (nav == "prev") {
            if (searchPins.indexOf(pagenum) == 0) {
                idx = 0;
            } else {
                idx = searchPins.indexOf(pagenum) - 1;
            }
        } else if (nav == "next") {
            if (searchPins.indexOf(pagenum) == searchPins.length - 1) {
                idx = searchPins.length - 1;
            } else {
                idx = searchPins.indexOf(pagenum) + 1;
            }
        }
        targetpage = searchPins[idx] - 1;
        jumpToIndex(targetpage);
    }

    function updateTitle() {
        var pagenum = $("#islandora-openseadragon").attr("pagenum");
        var label = Drupal.settings.islandoraInternetArchiveBookReader.label;
        var numOfPages = Drupal.settings.islandoraInternetArchiveBookReader.pages.length;
        //$(".modal-title").text(Drupal.t("Showing page: ") + pagenum + " / " + numOfPages + " | " + label);
        $("#pagemodal .modal-title").text(Drupal.t("Showing page: ") + pagenum + " / " + numOfPages);
    };

    function prepareOSD(ppid) {
        // TODO: Check the page mode. 1up, 2up or grid.
        $("#islandora-openseadragon").empty();
        Drupal.settings.islandora_open_seadragon_viewer = "";
        Drupal.settings.islandoraOpenSeadragon = "";

        $.get("https://" + window.location.host + "/zoom-islandora-object/" + ppid, function(data, status) {
            var viewer = new OpenSeadragon(data.settings.options);
            Drupal.settings.islandora_open_seadragon_viewer = viewer;
            Drupal.settings.islandoraOpenSeadragon = data.settings;
        });

        var arr = Drupal.settings.islandoraInternetArchiveBookReader.searchResults;
        if (typeof arr == "undefined") {
            searched = false;
        } else {
            prepareHighlights();
            searched = true;
            toggleHighlights();
        }
        updateTitle();
    };

    function prepareHighlights() {
        highlights = [];
        var searchResults = Drupal.settings.islandoraInternetArchiveBookReader.searchResults;
        for (i = 0; i < searchResults.length; i++) {
            var ppagenum = searchResults[i].par[0].page;

            if (highlights.hasOwnProperty(ppagenum) == false) {
                highlights[ppagenum] = [];
            }

            for (j = 0; j < searchResults[i].par[0].boxes.length; j++) {
                var hl_bottom = searchResults[i].par[0].boxes[j].b;
                var hl_top = searchResults[i].par[0].boxes[j].t;
                var hl_left = searchResults[i].par[0].boxes[j].l;
                var hl_right = searchResults[i].par[0].boxes[j].r;
                var hl_width = hl_right - hl_left;
                var hl_height = hl_bottom - hl_top;

                var highlight = {
                    "hl_top": hl_top,
                    "hl_left": hl_left,
                    "hl_width": hl_width,
                    "hl_height": hl_height
                };
                highlights[ppagenum].push(highlight);
            };
        };
    };

    function toggleHighlights() {
        var pagenum = $("#islandora-openseadragon").attr("pagenum");
        if (highlights[parseInt(pagenum)] == undefined) {
            console.log("no results found.");
        } else {
            showHighlights(highlights[parseInt(pagenum)]);
        }
    };

    function showHighlights(phighlights) {
        var overlays = [];
        var pagenum = $("#islandora-openseadragon").attr("pagenum");
        for (i = 0; i < phighlights.length; i++) {
            var overlay = {
                id: 'highlight-' + String(i + 1),
                px: phighlights[i].hl_left,
                py: phighlights[i].hl_top,
                width: phighlights[i].hl_width,
                height: phighlights[i].hl_height,
                className: "islandora-openseadragon-highlight"
            };
            overlays.push([overlay]);
        };

        if (viewerIsReady()) {
            hilitemup(overlays);
        } else {
            setTimeout(toggleHighlights, 500);
        }
    };

    function viewerIsReady() {
        var viewer = Drupal.settings.islandora_open_seadragon_viewer;
        if (viewer.world == undefined) {
            return false;
        } else {
            var tiledImage = viewer.world.getItemAt(0);
            if (!tiledImage) {
                return false;
            } else {
                return true;
            }
        }
    }

    function hilitemup(overlaySets) {
        $(".islandora-openseadragon-highlight").remove();
        var viewer = Drupal.settings.islandora_open_seadragon_viewer;
        overlaySets.forEach(function(overlaySet, setIndex) {

            var tiledImage = viewer.world.getItemAt(0);
            overlaySet.forEach(function(overlay) {
                var rect = new OpenSeadragon.Rect(overlay.px, overlay.py, overlay.width, overlay.height);
                rect = tiledImage.imageToViewportRectangle(rect);
                overlay.x = overlay.px;
                overlay.y = overlay.py;
                overlay.width = overlay.width;
                overlay.height = overlay.height;
                viewer.addOverlay(overlay);
            });
        });
    };

    function getMatchIndex(nav) {
        pagenum = $("#islandora-openseadragon").attr("pagenum");
        cHighlights = Object.keys(highlights);
        if (cHighlights.includes(pagenum) == false) {
            cHighlights.push(pagenum);
        }
        cHighlights = cHighlights.map(Number);

        function sortNumber(a, b) {
            return a - b;
        }

        cHighlights.sort(sortNumber);
        var idx = cHighlights.indexOf(parseInt(pagenum));
        if (nav == "next") {
            if (idx == cHighlights.length - 1) {
                idx = idx;
                alert(Drupal.t("This is the last result on this object."));
            } else {
                idx += 1;
            }
        } else if (nav == "prev") {
            if (idx == 0) {
                idx = idx;
                alert(Drupal.t("This is the first result on this object."));
            } else {
                idx -= 1;
            }
        }
        return cHighlights[idx];
    };

    $("#prev-page").click(function() {
        var pagenum = parseInt($("#islandora-openseadragon").attr("pagenum"));
        if (pagenum == 1) {
            alert(Drupal.t("You are on the first page of this object."));
            pagenum = pagenum;
        } else {
            pagenum = pagenum - 1;
        }
        $("#islandora-openseadragon").attr("pagenum", pagenum);
        var ppid = Drupal.settings.islandoraInternetArchiveBookReader.pages[pagenum - 1].pid;
        prepareOSD(ppid);
    });

    $("#next-page").click(function() {
        var pagenum = parseInt($("#islandora-openseadragon").attr("pagenum"));
        var maxpagenum = Drupal.settings.islandoraInternetArchiveBookReader.pages.length;
        if (pagenum == maxpagenum) {
            alert(Drupal.t("You are on the last page of this object."));
            pagenum = pagenum;
        } else {
            pagenum = pagenum + 1;
        }
        $("#islandora-openseadragon").attr("pagenum", pagenum);
        var ppid = Drupal.settings.islandoraInternetArchiveBookReader.pages[pagenum - 1].pid;
        prepareOSD(ppid);
    });

    $("#next-match").click(function() {
        if (searched == false) {
            alert(Drupal.t("Either no results found from your search or you didn't search anything."));
        } else {
            var idx = getMatchIndex("next");
            var ppagenum = parseInt(idx);
            var ppid = Drupal.settings.islandoraInternetArchiveBookReader.pages[ppagenum - 1].pid;
            $("#islandora-openseadragon").attr("pagenum", ppagenum);
            prepareOSD(ppid);
        }
    });

    $("#prev-match").click(function() {

        if (searched == false) {
            alert(Drupal.t("Either no results found from your search or you didn't search anything."));
        } else {
            var idx = getMatchIndex("prev");
            var ppagenum = parseInt(idx);
            var ppid = Drupal.settings.islandoraInternetArchiveBookReader.pages[ppagenum - 1].pid;
            $("#islandora-openseadragon").attr("pagenum", ppagenum);
            prepareOSD(ppid);
        }
    });

    $("#prev-book-search-match").click(function() {
        var currentpage = $(".currentpage").text().replace(/[^\d.]/g, '');
        var currentIdxInPins = prepareSearchPins(currentpage, "prev");
    });

    $("#next-book-search-match").click(function() {
        var currentpage = $(".currentpage").text().replace(/[^\d.]/g, '');
        var currentIdxInPins = prepareSearchPins(currentpage, "next");
    });

    function resetOSD() {
        Drupal.settings.islandora_open_seadragon_viewer.viewport.setRotation(0);
        Drupal.settings.islandora_open_seadragon_viewer.viewport.goHome();
    }

    if ($(".currentpage").text() == "") {
        $(".currentpage").text(Drupal.t("Page") + " 1");
    };

    $("body.not-logged-in .info-detail").append('<p>' + Drupal.t('To see metadata you need to be an authenticated user. Click <a href="/user">here</a> to log in.') + '</p>');

    $("#tabs-right-highlight").click(function() {
        var viewer = Drupal.settings.islandora_open_seadragon_viewer;
        var runtimed = $(".islandora-openseadragon-runtime-highlight").length;
        resetOSD();
        if (runtimed == 0) {
            // Fixed highlights are not exists.
            $(".islandora-openseadragon-highlight").each(function() {
                var hid = $(this).attr("id");
                var ovr = viewer.getOverlayById(hid);
                var ovr_pos = ovr.position;
                console.log(ovr_pos);

                elt = document.createElement("div");
                elt.className = "islandora-openseadragon-runtime-highlight";
                elt.id = hid.replace("highlight", "runtime-highlight");

                viewer.addOverlay({
                    element: elt,
                    location: new OpenSeadragon.Point(ovr_pos.x, ovr_pos.y),
                    checkResize: false
                });
            });
        } else {
            // Fixed highlights are exists. Returning to normal ones.
            $(".islandora-openseadragon-runtime-highlight").each(function() {
                $(this).toggle();
            });
        }
    });

});
