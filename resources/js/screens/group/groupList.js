$(document).ready(function () {

    $('#formImportCSV input[type="file"]').on('change', function () {
        $(this).valid();
    })

    $('#formImportCSV').validate({
        rules: {
            'csvFile': {
                required: {
                    depends: function(element) {
                        return $(element).val() === "";
                    }
                },
                extension: 'csv',
                fileSize: 2 * 1024 * 1024,
            }
        },
        messages: {
            'csvFile': {
                required: "File は必須です。",
                extension: function (extension) {
                    return jQuery.validator.messages.extension('CSV');
                },
                fileSize: function (param, element) {
                    var sizeLimit = param / 1024 / 1024;
                    return 'ファイルのサイズ制限'+sizeLimit+'MBを超えています。';
                },

            }
        },
    });


    var errorList = $('#errorList');
    var errorsExist = errorList.find('li').length > 0;
    if (errorsExist) {
        $('#errorModal').modal('show');
    }

    $('#importCSVModal').on('hidden.bs.modal', function () {
        $('#csvFile').removeClass('error-message');
        $('#csvFile-error').remove();
    });
    
});