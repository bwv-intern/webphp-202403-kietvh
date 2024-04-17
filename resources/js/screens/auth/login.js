$(function() {
    $('#login-form').validate({
        rules: {
            email: {
                required: true,
                checkValidEmailRFC: true,
                maxlength: 255,

            },
            password: {
                required: true,
                maxlength: 20,
            },
        },
    });
});
