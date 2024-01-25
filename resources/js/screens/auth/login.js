$(function() {
    $('#login-form').validate({
        rules: {
            email: {
                required: true,
            },
            password: {
                required: true,
            },
        },
    });
});
