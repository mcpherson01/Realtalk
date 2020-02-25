// Define folder scan default
var curFolders = wpsol_addon_folders.selected;

jQuery(document).ready(function ($) {
    //Scan file to exclude minify
    $('#wpsol-exclude-files-scan').on('click',function () {
        wpsol_exclude_scan();
    });

    $("#run-scan-file-popup").on("click",function (){
        $("#wpsol_check_exclude_file_modal").dialog("close");
        $("#wpsol-exclude-files").show();
        wpsol_exclude_scan();
    });

    $("#stop-scan-file-popup").on("click",function (){
        $("#excludeFiles-minification").prop("checked", false).attr("value","0");
        $("#wpsol_check_exclude_file_modal").dialog("close");
    });

    function wpsol_exclude_scan(){
        showDialog({
            id: 'wpsol-addon-scan-folders',
            title: optimization_params.wpsol_scan_folder_title,
            text: '<div id="wpsol_jao"></div>',
            negative: {
                id: 'wpsol-scan-close',
                title: optimization_params.wpsol_scan_folder_cancel_button,
                onClick: function() {  }
            },
            positive: {
                id: 'wpsol-scan-submit',
                title: optimization_params.wpsol_scan_folder_scan_button,
                onClick: function() {
                    wpsol_scan_submit();
                }
            },
            cancelable: true,
            contentStyle: {'max-width': '600px'}
        });

        wpsol_show_foldertree();
        wpsol_foldertree_after_open();
    }

    // Scanning
    var wpsol_scan_submit = function (){
        showDialog({
            id: 'wpsol-addon-scanning',
            title: ' <div id="wpsol-scanning-caption"></div>',
            text: '<div id="wpsol-progress"><div id="wpsol-progress-loading"></div></div>',
            positive: {
                id: 'wpsol-view-results',
                title: optimization_params.wpsol_scan_folder_results,
                onClick: function() {
                    location.href = 'admin.php?page=wpsol_speed_optimization#group_and_minify';
                    window.location.reload(true);
                }
            },
            cancelable: false,
            contentStyle: {
                'max-width': '600px'
            }
        });

        $('#wpsol-view-results').prop('disabled',true);
        $("#wpsol-progress").progressbar({
            value: 0
        });
        var folders = wpsol_selectFolders();

        $.ajax({
            url : ajaxurl,
            method : "POST",
            dataType : "json",
            data : {
                action : 'wpsol_addon_scan_dir',
                folders : folders,
                ajaxnonce : folders_nonce.ajaxnonce
            },success : function(res){
                $("#wpsol-progress-loading").text('0%');
                var i = 0 ;
                var scan = function (dir, path) {
                    $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'wpsol_addon_scan_exclude_files',
                            dir: dir,
                            ajaxnonce : folders_nonce.ajaxnonce
                        },
                        success: function (res) {
                            $("#wpsol-scanning-caption").text(optimization_params.wpsol_scan_folder_scanning);
                            i++;
                            $("#wpsol-progress").progressbar({
                                value : Math.floor(parseInt(i)*100/parseInt(path.length)),
                                change: function() {
                                    $("#wpsol-progress-loading").text( $("#wpsol-progress").progressbar( "value" ) + "%");
                                }
                            });

                            if (i < path.length) {
                                scan(path[i], path);
                            } else {
                                $("#wpsol-scanning-caption").text(optimization_params.wpsol_scan_folder_complete);
                                $('#wpsol-view-results').prop('disabled',false);
                            }

                        }
                    });
                };

                scan(res[i], res);

            }
        });
    };

    //Show folder
    var wpsol_show_foldertree = function(){
        $('#wpsol_jao').wpsol_jaofiletree({
            script: ajaxurl,
            usecheckboxes: true,
            showroot: '/',
            oncheck: function (elem, checked, type, file) {
                var dir = file;
                var alldir = [];
                $('ul.wpsol_jaofiletree li input[type="checkbox"]').each(function(i,v)
                {
                    if(i != 0){
                        var f = $(v).data('file');
                        if (f.substring(f.length - 1) == sdir) {
                            f = f.substring(0, f.length - 1);
                        }
                        if (f.substring(0, 1) == sdir) {
                            f = f.substring(1, f.length);
                        }
                        alldir.push(f);
                    }
                });
                if (file.substring(file.length - 1) == sdir) {
                    file = file.substring(0, file.length - 1);
                }
                if (file.substring(0, 1) == sdir) {
                    file = file.substring(1, file.length);
                }
                if (checked) {
                    if (file !== "" && curFolders.indexOf(file) == -1) {
                        curFolders.push(file);
                    }else if(curFolders.indexOf(file) == -1){
                        var array = curFolders.concat(alldir);
                        var a = array.concat();
                        for(var i=0; i<a.length; ++i) {
                            for(var j=i+1; j<a.length; ++j) {
                                if(a[i] === a[j])
                                    a.splice(j--, 1);
                            }
                        }
                        curFolders = a;
                    }
                } else {
                    if (file != "" && !$(elem).next().hasClass('pchecked')) {
                        var temp = [];
                        for (i = 0; i < curFolders.length; i++) {
                            var curDir = curFolders[i];
                            if (curDir.indexOf(file) !== 0) {
                                temp.push(curDir);
                            }
                        }
                        curFolders = temp;
                    } else {
                        var index = curFolders.indexOf(file);
                        if (index > -1) {
                            curFolders.splice(index, 1);
                        }
                    }

                }

            }
        });
    };
    //After show
    var wpsol_foldertree_after_open = function(){
        jQuery('#wpsol_jao').bind('afteropen', function () {
            jQuery(jQuery('#wpsol_jao').wpsol_jaofiletree('getchecked')).each(function () {
                var curDir = this.file;
                if (curDir.substring(curDir.length - 1) == sdir) {
                    curDir = curDir.substring(0, curDir.length - 1);
                }
                if (curDir.substring(0, 1) == sdir) {
                    curDir = curDir.substring(1, curDir.length);
                }
                if (curFolders.indexOf(curDir) == -1) {
                    curFolders.push(curDir);
                }
            });
            wpsol_spanCheckInit();

        });

        var wpsol_spanCheckInit = function () {
            $("span.check").unbind('click').bind('click', function () {
                $(this).removeClass('pchecked');
                $(this).toggleClass('checked');
                if ($(this).hasClass('checked')) {
                    $(this).prev().prop('checked', true).trigger('change');
                } else {
                    $(this).prev().prop('checked', false).trigger('change');
                }
                wpsol_setParentState(this);
                wpsol_setChildrenState(this);
            });
        };

        var wpsol_setParentState = function (obj) {
            var liObj = $(obj).parent().parent(); //ul.jaofiletree
            var noCheck = 0, noUncheck = 0, totalEl = 0;
            liObj.find('li span.check').each(function () {

                if ($(this).hasClass('checked')) {
                    noCheck++;
                } else {
                    noUncheck++;
                }
                totalEl++;
            });

            if (totalEl == noCheck) {
                liObj.parent().children('span.check').removeClass('pchecked').addClass('checked');
                liObj.parent().children('input[type="checkbox"]').prop('checked', true).trigger('change');
            } else if (totalEl == noUncheck) {
                liObj.parent().children('span.check').removeClass('pchecked').removeClass('checked');
                liObj.parent().children('input[type="checkbox"]').prop('checked', false).trigger('change');
            } else {
                liObj.parent().children('span.check').removeClass('checked').addClass('pchecked');
                liObj.parent().children('input[type="checkbox"]').prop('checked', false).trigger('change');
            }

            if (liObj.parent().children('span.check').length > 0) {
                wpsol_setParentState(liObj.parent().children('span.check'));
            }
        };

        var wpsol_setChildrenState = function (obj) {
            if ($(obj).hasClass('checked')) {
                $(obj).parent().find('li span.check').removeClass('pchecked').addClass("checked");
                $(obj).parent().find('li input[type="checkbox"]').prop('checked', true).trigger('change');
            } else {
                $(obj).parent().find('li span.check').removeClass("checked");
                $(obj).parent().find('li input[type="checkbox"]').prop('checked', false).trigger('change');
            }

        }
    };

    var sdir = '/';
    var wpsol_selectFolders = function () {

        var fchecked = [];
        curFolders.sort();
        for (var i = 0; i < curFolders.length; i++) {
            var curDir = curFolders[i];
            var valid = true;
            for (var j = 0; j < i; j++) {
                if (curDir.indexOf(curFolders[j]) == 0) {
                    valid = false;
                }
            }
            if (valid) {
                fchecked.push(curDir);
            }
        }

        return fchecked;
    }
});
