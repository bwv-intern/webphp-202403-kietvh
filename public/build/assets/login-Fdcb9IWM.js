$(function(){$("#login-form").validate({rules:{email:{required:!0,email:!0,maxlength:255},password:{required:!0,maxlength:20}},messages:{email:{email:"メールアドレスを正しく入力してください。"}}})});
