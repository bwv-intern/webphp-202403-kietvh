$(document).ready(function () {

    $('#formImportCSV input[type="file"]').on('change', function() {
        $(this).valid();
    })

    $('#formImportCSV').validate({
        rules: {
            'csvFile': {
                extension: 'csv|txt',
            }
        },
        messages: {
            'csvFile': {
                extension: function(extension) {
                    return jQuery.validator.messages.extension('CSV');
                }
            }
        },
    });
});