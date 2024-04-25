$.validator.addMethod(
    'dateDMY',
    function (value, element) {
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    },
);

$.validator.addMethod("azAZ09", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
  }, "パスワードには半角数字のみ、または半角英字のみの値は使用できません。");