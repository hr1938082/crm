/**
 * Admin JS - admin js for Office Manager theme
 * @version v1.0.0
 * @copyright 2018 Pepdev.
 */
/**
 * Mobile Menu Open/Close
 * Data-Title Tool tip bootstrap
 * Date Range Picker
 * Left Menu
 * Add Contact Persons
 * Add Task
 * Delete Item From List
 * Listing Table
 * Image  Uplaod
 */
 $(document).ready(function () {
    "use strict";

    //********************************************
    //Data-Title Tool tip bootstrap **************
    //********************************************
    $('[data-toggle="tooltip"]').tooltip();
    
    //********************************************
    //Mobile Menu Open/Close *********************
    //********************************************
    $(window).resize(function () {
        if ($(window).width() > 576) {
            $('#menu-wrapper').show();
        }
    });
    
    $('body').on('click', '.mobile-menu-open', function () {
        $('.mobile-menu-background').show();
        $('.menu-wrapper').show();
    });

    $('body').on('click', '.mobile-menu-background', function () {
        $('.mobile-menu-background').hide();
        $('.menu-wrapper').hide();

    });


    //Open Left Side Menu in mobile
    $('body').on('click', '.open-left-menu', function () {
        var ele = $('.menu-wrapper'), nav_ele = $('.navbar-container');
        $('body').append('<div class="menu-overlay"></div>');
        ele.addClass('menu-mobile-open');
        nav_ele.addClass('menu-mobile-open');
    });

    
    //Close Left Side Menu in mobile
    $('body').on('click', '.menu-overlay', function () {
        $('.menu-wrapper, .navbar-container').removeClass('menu-mobile-open');
        $('.menu-overlay').remove();
    });

    //********************************************
    //Date Range Picker **************************
    //********************************************
    $('.date').daterangepicker({
        singleDatePicker: true,
        autoApply: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY',
            separator: " - ",
        }
    });

    $('.date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });

    $('.date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('.datetime').daterangepicker({
        singleDatePicker: true,
        timePicker : true,
        autoApply: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY h:mm A',
            separator: " - ",
        }
    });

    $('.datetime').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY h:mm A'));
    });

    $('.datetime').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    
    //*************************************************
    //Full Screen  ************************************
    //************************************************* 
    function launchIntoFullscreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }

    $('body').on('click', '.page-fullscreen', function () {
        var ele = $(this), target_ele = ele.find('a .fa-expand');
        if (target_ele.length > 0) {
            launchIntoFullscreen(document.documentElement);
            target_ele.addClass('fa-compress');
            target_ele.removeClass('fa-expand');
        } else {
            exitFullscreen();
            ele.find('a i').addClass('fa-expand');
            ele.find('a i').removeClass('fa-compress');
        }
    });


    //********************************************
    //Left Menu **********************************
    //********************************************
    $('body').on('click', '.menu-close', function () {
        var ele = $(this);
        $('#menu-wrapper').css('width', '60px');
        $('.page-wrapper').css('margin-left', '60px');
        ele.find('i').removeClass('fa-hand-o-left');
        ele.find('i').addClass('fa-hand-o-right');
        ele.removeClass('menu-close');
        ele.addClass('menu-open');
    });

    $('body').on('click', '.menu-open', function () {
        var ele = $(this);
        $('#menu-wrapper').css('width', '250px');
        $('.page-wrapper').css('margin-left', '250px');
        ele.find('i').removeClass('fa-hand-o-right');
        ele.find('i').addClass('fa-hand-o-left');
        ele.removeClass('menu-open');
        ele.addClass('menu-close');
    });


    //********************************************
    //Delete Item From List **********************
    //********************************************
    $('body').on('click', '.table-delete', function () {
        $('.delete-card-button input').val($(this).find('input').val());
        $("#delete-card").modal({
            keyboard: true
        });
    });


    //*************************************************
    //Left Side menu  *********************************
    //*************************************************
    $('body').on('click', '.menu-close', function () {
        var ele = $(this);
        $('#main-wrapper').addClass('page-menu-small');
        ele.find('i').removeClass('fa-hand-point-left');
        ele.find('i').addClass('fa-hand-point-right');
        ele.removeClass('menu-close');
        ele.addClass('menu-open');
    });

    $('body').on('click', '.menu-open', function () {
        var ele = $(this);
        $('#main-wrapper').removeClass('page-menu-small');
        ele.find('i').removeClass('fa-hand-point-right');
        ele.find('i').addClass('fa-hand-point-left');
        ele.removeClass('menu-open');
        ele.addClass('menu-close');
    });
    
    //Left side Sub Menu
    $('body').on('click', 'li.has-sub > a', function () {
        var ele = $(this), target = ele.parent('li.has-sub').find('ul.sub-menu:first');
        ele.parent('li.has-sub').siblings('li').find('a .arrow').removeClass('rotate');
        if (target.css('display') === "none") {
            ele.parent('li.has-sub').siblings('li').find('.sub-menu').slideUp(300);
            ele.find('.arrow').addClass('rotate');
            target.slideDown(300);
        } else {
            ele.parent('li.has-sub').find('.arrow').removeClass('rotate');
            ele.parent('li.has-sub').find('ul.sub-menu').slideUp(300);
        }
        return false;
    });

    if ($('.menu-fixed').length > 0 && $('.menu-wrapper').length > 0) {
        new PerfectScrollbar('.menu-fixed .menu-wrapper .menu ul', {
            wheelSpeed: 2,
            minScrollbarLength: 20
        });
    }

    //********************************************
    //Listing Table ******************************
    //********************************************
    var datatable = $('.datatable-table').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "iDisplayLength": 10,
        "order": [],
        'responsive': true,
        "pagingType": 'full_numbers',
        'language': {
            "lengthMenu": "_MENU_",
            "zeroRecords": $('#datatable_no_records').val(),
            "info": $('#text_showing_page').val(),
            "infoEmpty": $('#datatable_no_reocrds').val(),
            "infoFiltered": "",
            "search": '<i class="icon-magnifier"></i>',
            "paginate": {
                "first":       '<i class="fa fa-angle-double-left"></i>',
                "previous":    '<i class="fa fa-angle-left"></i>',
                "next":        '<i class="fa fa-angle-right"></i>',
                "last":        '<i class="fa fa-angle-double-right"></i>'
            },
        }
    });


    //********************************************
    //Image  Uplaod ******************************
    //********************************************
    $('.image-upload').click(function () {
        $(this).parent().addClass('image-upload-progress');
        $("#media-upload").on('show.bs.modal', function () {
            var path = $('input[name=absolute-upload-path]').val();
            JSON.parse($('input[name=media_all]').val()).forEach(function (element) {
                $('#media-upload .media-all').append(
                    '<div class="media-all-block">' +
                    '<div>' +
                    '<a data-toggle="tooltip" data-placement="top" title="Remove"><i class="icon-trash"></i></a>' +
                    '<img src="' + path.concat(element) + '" title="' + element + '">' +
                    '<input type="radio" name="media-select" id="media-' + element + '" value="' + element + '">' +
                    '<label for="media-' + element + '" title="' + element + '">' + element + '</label>' +
                    '</div></div>');
            });
        }).modal('show');
        $('input[name=media_all]').val('[]');
    });

    $("#media-upload").on('hidden.bs.modal', function () {
        $(this).parent().removeClass('image-upload-progress');
    });

    Dropzone.autoDiscover = false;
    $("#media-dropzone").dropzone({
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
        dictDefaultMessage: $('input[name=text_language]').val(),
        success: function (file, response) {
            $('.media-all').prepend('<div class="media-all-block"><div>' +
                '<a class="data-title" data-title="Remove"><i class="icon-trash"></i></a>' +
                '<img src="public/uploads/' + response + '" title="' + response + '">' +
                '<input type="radio" name="media-select" id="media-' + response + '" value="' + response + '">' +
                '<label for="media-' + response + '"><span></span> ' + response + '</label>' +
                '</div></div>');
            this.removeFile(file);
        }
    });

    $('.media-all').on('click', '.media-all-block div img', function () {
        $('.image-upload-progress .saved-picture').append('<img src="public/uploads/' + $(this).attr('title') + '" alt="">');
        $('.image-upload-progress .saved-picture input[type=hidden]').val($(this).attr('title'));
        $('.image-upload-progress .saved-picture').show();
        $('.image-upload-progress .image-upload').hide();
        $('.image-upload-progress .saved-picture-delete').show();
        $('.content-input').removeClass('image-upload-progress');
        $('#media-upload').modal('hide');
    });

    //Image Delete 
    $('.media-all').on('click', '.media-all-block div a', function () {
        var ele = $(this),
        image_name = ele.siblings('input').val(),
        path = $('input[name=absolute-path]').val().concat('upload/delete');
        $.ajax({
            method: "POST",
            url: path,
            data: {page: 'media',name: image_name},
            error: function () {alert('Sorry Try Again!');},
            success: function (response) {
                if (response == '1') {
                    ele.parents('.media-all-block').remove();
                } else {
                    alert('Wanrning: File could not be deleted!');
                }
            }
        });
    });

    $('.saved-picture-delete').click(function () {
        $(this).siblings('.saved-picture').find('img').remove();
        $(this).siblings('.saved-picture').find('input').val('');
        $(this).siblings('.saved-picture').hide();
        $(this).siblings('.image-upload').show();
        $(this).hide();
    });
});