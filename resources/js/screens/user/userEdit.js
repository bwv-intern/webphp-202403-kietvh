$(document).ready(function () {

    $('option').each(function () {
        console.log("OK");;
        var text = $(this).text();
        if (text.length > 20) {
            text = text.substring(0, 19) + '...';
            $(this).text(text);
        }
    });

    $("#deleteButton").click(function (e) {
        alert("hello");
    });

   
    $("#started-date").datepicker({
        dateFormat: 'dd/mm/yy',
    });
   

    $('#formEditUser').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 100,
            },
            'email': {
                required: true,
                checkValidEmailRFC: true,
                maxlength: 255,
            },
            'started_date': {
                required: true,
                dateDMY: true,
            },
            'password': {
               
                azAZ09: true,
                maxlength: 20,
            },
            'repassword': {
                required: function (element) {
                    return $('#password').val().length > 0;
                },
                azAZ09: true,
                maxlength: 20,
                equalTo: "#password",
            }

        },
        messages: {
            'started_date': {
                dateDMY: "Started Date Toは日付を正しく入力してください。" 
            },
            'password': {
                azAZ09: "パスワードには半角数字のみ、または半角英字のみの値は使用できません。", // EBT025
            },
            'repassword': {
                azAZ09: "パスワードには半角数字のみ、または半角英字のみの値は使用できません。", // EBT025
                equalTo: "確認用のパスワードが間違っています。", // EBT030
            }
        }
    });
   


});