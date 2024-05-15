$(document).ready(function () {

    $('#formImportCSV input[type="file"]').on('change', function () {
        $(this).valid();
    })

    $('#formImportCSV').validate({
        rules: {
            'csvFile': {
                required: true,
                extension: 'csv',
            }
        },
        messages: {
            'csvFile': {
                required: "File は必須です。",
                extension: function (extension) {
                    return jQuery.validator.messages.extension('CSV');
                },
                fileSize: 2 * 1024 * 1024,
            }
        },
    });


    var errorList = $('#errorList');
    var errorsExist = errorList.find('li').length > 0;
    if (errorsExist) {
        $('#errorModal').modal('show');
    }
});