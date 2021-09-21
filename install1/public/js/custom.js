
$(document).ready(function() {
	
    "use strict";
    
    /*Form Validation*/
    $('#install-submit').click(function () {
        var clck_invld = 0,
            mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if ($('#address').val().trim().length < 7) {
            $('#address').parent('.form-input').addClass('is-invalid');
            $('#address').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#address').focus();
        }
        if ($('#password').val().trim().length < 7) {
            $('#password').parent('.form-input').addClass('is-invalid');
            $('#password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#password').focus();
        }
        if ($('#username').val().trim().length < 4) {
            $('#username').parent('.form-input').addClass('is-invalid');
            $('#username').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#username').focus();
        }
        if (!mail_filter.test($('#email').val())) {
            $('#email').parent('.form-input').addClass('is-invalid');
            $('#email').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#email').focus();
        }
        if ($('#name').val().trim().length < 3) {
            $('#name').parent('.form-input').addClass('is-invalid');
            $('#name').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#name').focus();
        }
        if ($('#db-prefix').val().trim().length < 1) {
            $('#db-prefix').parent('.form-input').addClass('is-invalid');
            $('#db-prefix').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#db-prefix').focus();
        }
        if ($('#db-hostname').val().trim().length < 2) {
            $('#db-hostname').parent('.form-input').addClass('is-invalid');
            $('#db-hostname').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#db-hostname').focus();
        }
        if ($('#db-password').val().trim().length < 2) {
            $('#db-password').parent('.form-input').addClass('is-invalid');
            $('#db-password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#db-password').focus();
        }
        if ($('#db-username').val().trim().length < 2) {
            $('#db-username').parent('.form-input').addClass('is-invalid');
            $('#db-username').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#db-username').focus();
        }
        if ($('#db-name').val().trim().length < 2) {
            $('#db-name').parent('.form-input').addClass('is-invalid');
            $('#db-name').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#db-name').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });
});