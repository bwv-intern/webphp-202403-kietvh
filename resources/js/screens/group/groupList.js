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

    // fix colum table
    $(window).on('resize', function() {
        const container = $('.table-container');
        const containerWidth = container.outerWidth();
        const columnWidth = containerWidth / 8;
    
        const table = container.find('.group-list-table');
        const cells = table.find('td, th');
        cells.css({
            width: columnWidth + 'px',
            maxWidth: columnWidth + 'px',
            minWidth: columnWidth + 'px'
        });
    });
   
});