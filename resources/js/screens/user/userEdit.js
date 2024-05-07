$(document).ready(function () {

    $('option').each(function () {
        var text = $(this).text();
        if (text.length > 20) {
            text = text.substring(0, 19) + '...';
            $(this).text(text);
        }
    });

   
   
    $("#started-date").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (selectedDate) {
            $('#started-date').valid();
        }
    });
   
    $("#password").on('input', function() {
        if($("#password").val().length > 0){
            $("#password").closest('.input-group').find('label').addClass('input-required');
            $("#repassword").closest('.input-group').find('label').addClass('input-required');
        }
        else{
            $("#password").closest('.input-group').find('label').removeClass('input-required');
            $("#repassword").closest('.input-group').find('label').removeClass('input-required');
        }
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
                remote: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/user/checkemail/",
                    type: "POST",
                    data: {
                        id: function () {
                            return $('#id').val();
                        },
                        email: function () {
                            return $('#email').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataFilter: function (response) {
                        var data = JSON.parse(response); 
                        console.log(response)
                        if (data.duplicate === true) {
                            console.log("OK");
                           return false;
                        }
                        return true;
                    }
                },
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
            'email':{
                remote: 'すでにメールアドレスは登録されています。', // EBT019
            },
            'started_date': {
                dateDMY: "Started Date Toは日付を正しく入力してください。" 
            },
            'password': {
            },
            'repassword': {
                equalTo: "確認用のパスワードが間違っています。", // EBT030
            },
            'group_id': {
                notNull: "Groupは必須です。",
            },
            'position_id': {
                notNull: "Positionは必須です。",
            },
            
        }
    });
   

});