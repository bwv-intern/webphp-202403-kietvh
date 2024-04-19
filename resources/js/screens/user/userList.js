$(function () {
    $("#started-date-from").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (selectedDate) {
            $('#started-date-from').valid();
        }
    });

    $("#started-date-to").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (selectedDate) {
            $('#started-date-from').valid();
        }
    });

    // $('#formSearch').validate({
    //     rules: {
    //         'name': {
    //             maxlength: 100,
    //         },
    //         'started_date_from': {
    //             dateDMY: true,
    //             startDateBeforeEndDate: true,
    //         },
    //         'started_date_to': {
    //             dateDMY: true,
    //         },
    //     },
    //     messages: {
    //         'started_date_to': {
    //             dateDMY : "Started Date Toは日付を正しく入力してください。"
    //         },
    //         'started_date_from': {
    //             dateDMY : "Started Date Fromは日付を正しく入力してください。"
    //         },
    //     }
    // });

    $("#btnClear").click(function (e) { 
        alert("Nút clear"); 
    });
    $("#btnNew").click(function (e) { 
        alert("Nút New"); 
    });
    $("#btnExport").click(function (e) { 
        alert("Nút Export"); 
    });
});