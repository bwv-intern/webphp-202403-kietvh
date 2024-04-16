$(function() {
    $('#login-form').validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 255,

            },
            password: {
                required: true,
                maxlength: 20,
            },
        },
        messages :{
            email: {
                email: "メールアドレスを正しく入力してください。"
            },
        }
    });
});
