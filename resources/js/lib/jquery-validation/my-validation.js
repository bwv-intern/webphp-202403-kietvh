$.validator.addMethod(
    'dateDMY',
    function (value, element) {
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    },
);