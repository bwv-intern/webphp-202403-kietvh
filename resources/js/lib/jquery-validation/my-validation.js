$.validator.addMethod(
    'dateDMY',
    function (value, element) {
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    },
    function (p, e) {
        return $.validator.format(
            '{0}は日付を正しく入力してください。',
            [$(e).data('label')]
        );
    }
);