$().ready(function() {
    jQuery.extend(jQuery.validator.messages, {
        katakanaMaxLength: jQuery.validator.format('{0}は「{1}」文字以下で入力してください。（現在{2}文字）'),
        onlyNumberAndAlphabetForPassword: jQuery.validator.format('パスワードには半角数字のみ、または半角英字のみの値は使用できません。'),
        onlyNumberAndAlphabetOneByte: jQuery.validator.format('{0}は半角英数で入力してください。'), //EBT004
        stringValueRange: jQuery.validator.format('パスワードは半角英数字記号で8～20文字で入力してください。'),
        existsEmail: jQuery.validator.format('すでにメールアドレスは登録されています。'),
    });
})