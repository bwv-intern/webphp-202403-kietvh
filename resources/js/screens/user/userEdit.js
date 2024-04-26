$(document).ready(function () {

    $('option').each(function () {
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
                katakanaMaxLength: 100,
            },
            'email': {
                required: true,
                checkValidEmailRFC: true,
                maxlength: 255,
            },
            'group_id': {
                required: true,
                notNull: true,
                onlyNumberAndAlphabetOneByte: true,
            },

            'position_id': {
                required: true,
                notNull: true,
                onlyNumberAndAlphabetOneByte: true,
            },

            'started_date': {
                required: true,
                dateDMY: true,
            },
            'password': {
                onlyNumberAndAlphabetForPassword: true,
                maxlength: 20,
                stringValueRange: [8, 20],
            },
            'repassword': {
                required: function (element) {
                    return $('#password').val().length > 0;
                },
                onlyNumberAndAlphabetForPassword: true,
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