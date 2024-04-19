$(function () {
    $("#started-date-from").datepicker();
    $("#started-date-to").datepicker();

    $('#formSearch').validate({
        rules: {
            'name': {
                maxlength: 100,
            },
            
            'started_date_from': {
                dateDMY : true,
            },
            'started_date_to': {
                dateDMY : true,
            },
        },
    });
});