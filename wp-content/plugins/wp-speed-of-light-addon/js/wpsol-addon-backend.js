jQuery(document).ready(function ($) {
    //Display exclude file after scan
    var display_exclude_file = function (page, filetype, search) {
        $.ajax({
            url: ajaxurl,
            dataType: 'json',
            method: 'POST',
            data: {
                action: 'wpsol_display_exclude_file',
                page: page,
                filetype: filetype,
                search: search,
                ajaxnonce: addon_admin_nonce.ajaxnonce
            },
            success: function (res) {
                if (res === false) {
                    $('#excludes-tab table .exclude-body').hide();
                    $('#excludes-tab table .exclude-pagination').hide();
                    $('#excludes-tab table .no-result').show();
                } else {
                    $('#excludes-tab table .exclude-body').html(res.body);
                    $('#excludes-tab table .exclude-pagination').html(res.pagging);
                }
            }
        });
    };

    display_exclude_file();

    // Paging
    $(document).on('click', '#wpsol-exclude-files li.paging', function () {
        var page = $(this).data('id');
        var file_type = $('input[name="exclude-file-type"]').val();
        var search = $('#wpsol-exclude-files-search-input').val();
        display_exclude_file(page, file_type, search);

        $('#wpsol-exclude-files li.paging').removeClass('choose');
        $(this).addClass('choose');
        $('input[id="minify-check-all"]').prop("checked", false);
    });

    // Search
    $(document).on('click', '#wpsol-exclude-files .wpsol-exclude-files-search-button', function () {
        var search = $('#wpsol-exclude-files-search-input').val();
        var file_type = $('input[name="exclude-file-type"]').val();
        display_exclude_file(1, file_type, search);

    });

    // Tabs exclude files
    $(document).on('click', 'ul.wpsol-exclude-files-tabs li', function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.wpsol-exclude-files-tabs li').removeClass('active');

        $(this).addClass('active');
        var type_class = 'all';
        if (tab_id === 0) {
            type_class = 'font';
        } else if (tab_id === 1) {
            type_class = 'css';
        } else if (tab_id === 2) {
            type_class = 'js';
        }
        $(this).addClass('wpsol-exclude-file-' + type_class);

        $('input[name="exclude-file-type"]').val(tab_id);

        var search = $('#wpsol-exclude-files-search-input').val();

        display_exclude_file(1, tab_id, search);

    });

    // Change minify

    $(document).on('click', '#active-minify', function () {
        var ids = [$(this).data('id')];
        var state = $(this).val();

        $.ajax({
            url: ajaxurl,
            dataType: 'json',
            method: 'POST',
            data: {
                action: 'wpsol_change_minify',
                ids: ids,
                state: state,
                ajaxnonce: addon_admin_nonce.ajaxnonce
            },
            success: function () {
                window.location.reload(true);
            }
        });
    });


    $('input[id="minify-check-all"]').click(function () {
        var checked = $(this).is(':checked');

        for (var i = 0; i < 10; i++) {
            if (checked === true) {
                $("#minify-check-" + i).prop("checked", true);
            } else {
                $("#minify-check-" + i).prop("checked", false);
            }
        }

    });

    $(document).on('click', '.minify-check', function () {
        var checked = $(this).is(':checked');
        if (checked === false) {
            $('input[id="minify-check-all"]').prop('checked', false);
        }
    });

    $(document).on('click', '#wpsol-exclude-files-toggle-state', function () {

        var ids = [];
        $('input[type=checkbox]:checked').each(function () {
            ids.push($(this).val());
        });

        $.ajax({
            url: ajaxurl,
            dataType: 'json',
            method: 'POST',
            data: {
                action: 'wpsol_toggle_minify',
                ids: ids,
                ajaxnonce: addon_admin_nonce.ajaxnonce
            },
            success: function () {
                window.location.reload(true);
            }
        });
    });


    $("#excludeFiles-minification").on("change", function () {
        if ($(this).is(':checked')) {
            $("#wpsol_check_exclude_file_modal").dialog("open");
        } else {
            $(".wpsol-exclude-field").hide();
        }
    });

    // Enter key to search
    $('#wpsol-exclude-files-search-input').bind("enterKey", function (e) {
        //do stuff here
        var search = $('#wpsol-exclude-files-search-input').val();
        var file_type = $('input[name="exclude-file-type"]').val();

        display_exclude_file(1, file_type, search);
    }).keyup(function (e) {
        if (e.keyCode === 13) {
            $(this).trigger("enterKey");
        }
    });
    /*
     Alert popup exclude file minification
     */
    $("#wpsol_check_exclude_file_modal").dialog({
        width: 570,
        height: 310,
        autoOpen: false,
        closeOnEscape: true,
        draggable: false,
        resizable: false,
        modal: true,
        dialogClass: 'noTitle',
        show: {
            effect: "fade",
            duration: 500
        },
        hide: {
            effect: "fade",
            duration: 500
        }
    });
});

