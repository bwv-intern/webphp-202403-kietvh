$(document).ready(function () {

    $('#formImportCSV input[type="file"]').on('change', function () {
        $(this).valid();
    })

    $('#formImportCSV').validate({
        rules: {
            'csvFile': {
                extension: 'csv',
            }
        },
        messages: {
            'csvFile': {
                extension: function (extension) {
                    return jQuery.validator.messages.extension('CSV');
                }
            }
        },
    });


    var errorList = $('#errorList');
    var errorsExist = errorList.find('li').length > 0;
    if (errorsExist) {
        $('#errorModal').modal('show');
    }
});