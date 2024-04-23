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

    $('#formSearch').validate({
        rules: {
            'name': {
                maxlength: 100,
            },
            'started_date_from': {
                dateDMY: true,
                startDateBeforeEndDate: true,
            },
            'started_date_to': {
                dateDMY: true,
            },
        },
        messages: {
            'started_date_to': {
                dateDMY: "Started Date Toは日付を正しく入力してください。"
            },
            'started_date_from': {
                dateDMY: "Started Date Fromは日付を正しく入力してください。"
            },
        }
    });

    $("#btnClear").click(function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/common/resetSearch',
            type: 'get',
            data: {
                screen: 'user.search',
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.hasError == false) {
                    $("#formSearch input[type='text']").val('');
                    $("#formSearch input[type='date']").val('');
                    $("#formSearch input[type='email']").val('');
                    $("#formSearch input[type='number']").val('');
                    window.history.replaceState( null, null, window.location.href );
                }
            }
        });
    });

    $("#btnNew").click(function (e) {
        alert("Nút New");
    });
    $("#btnExport").click(function (e) {
    });

    // turn off loading when downloaded file
    var checker = window.setInterval(function () {
        var founded = $.cookie('exported');
        if (founded) {
            _common.showLoading(false);
            $.removeCookie('exported', { path: '/' });
        }
    }, 1000);
});