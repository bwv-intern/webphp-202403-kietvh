$(function () {
    $("#started-date-from").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (selectedDate) {
            $('#started-date-from').valid();
        }
    }).on('change', function() {
        $(this).valid();
        $("#started-date-to").valid();
    });
;

    $("#started-date-to").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (selectedDate) {
            $('#started-date-from').valid();
        }
    }).on('change', function() {
        $(this).valid();
        $("#started-date-from").valid();
    });;

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
            $("#formSearch").trigger('reset');
            $("#formSearch").find('input:text, input:password, input:file, textarea').val('').removeClass("error-message");
            $(".error-message").remove();
            const newUrl = '/admin/user';
            window.history.pushState(null, '', newUrl);
        // $.ajax({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //     },
        //     url: '/admin/user/clear',
        //     type: 'post',
        //     dataType: 'json',
        //     success: function (response) {
        //         console.log(response);
        //         if (response.hasError == false) {
                    
        //         }
        //     }
        // });
    });

    $("#btnNew").click(function (e) {
        window.location.href = '/admin/user/add-edit-delete';
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

    $('option').each(function() {
        console.log("OK");;
        var text = $(this).text();
        if (text.length > 20) {
            text = text.substring(0, 19) + '...';
            $(this).text(text);
        }
    }); 
   
});

const container = $('.table-container');
const containerWidth = container.outerWidth();
console.log(containerWidth);
const columnWidth = containerWidth / 5;
console.log(columnWidth);
const table = container.find('.list-user-table');
const cells = table.find('td, th');
cells.css({
    width: columnWidth + 'px',
    maxWidth: columnWidth + 'px',
    minWidth: columnWidth + 'px'
});

// this for responsive event
$(window).on('resize', function() {
    const container = $('.table-container');
    const containerWidth = container.outerWidth();
    console.log(containerWidth);
    const columnWidth = containerWidth / 5;
    console.log(columnWidth);
    const table = container.find('.list-user-table');
    const cells = table.find('td, th');
    cells.css({
        width: columnWidth + 'px',
        maxWidth: columnWidth + 'px',
        minWidth: columnWidth + 'px'
    });
});
