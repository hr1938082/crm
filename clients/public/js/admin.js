/**
 * Admin JS - admin js for klinikal theme
 * @version v1.0.1
 * @copyright 2017 Pepdev.
 */
 $(document).ready(function () {
    "use strict";

    
    //********************************************
    //Data-Title Tool tip bootstrap **************
    //********************************************
    $('[data-toggle="tooltip"]').tooltip();

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


    //********************************************
    //Left Menu **********************************
    //********************************************

    $('body').on('click', '.menu-close', function () {
        var ele = $(this);
        $('#menu-wrapper').css('width', '60px');
        $('.page-wrapper').css('margin-left', '60px');
        ele.find('i').addClass('icon-arrow-right-circle');
        ele.removeClass('menu-close');
        ele.addClass('menu-open');
    });

    $('body').on('click', '.menu-open', function () {
        var ele = $(this);
        $('#menu-wrapper').css('width', '250px');
        $('.page-wrapper').css('margin-left', '250px');
        ele.find('i').removeClass('icon-arrow-right-circle');
        ele.removeClass('menu-open');
        ele.addClass('menu-close');
    });


    //********************************************
    //Listing Table ******************************
    //********************************************

    var datatable = $('.datatable-table').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "iDisplayLength": 25,
        "order": [],
        'responsive': true,
        'pagingType': 'full_numbers',
        'language': {
            "lengthMenu": "_MENU_",
            "zeroRecords": $('#datatable_no_records').val(),
            "info": $('#text_showing_page').val(),
            "infoEmpty": $('#datatable_no_records').val(),
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

});