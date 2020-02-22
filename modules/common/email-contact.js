$(window).on('load', function () {
    $(".contact-form input[type=button]").on('click', function () {
        const category = $(".contact-form select");
        const body = $(".contact-form textarea");

        if(!body.val()){
            alert("문의 내용을 입력해주세요.");
            body.trigger('focus');
        }
        const datas = new FormData();
        datas.append('category',String(category.val()));
        datas.append('body',String(body.val()));
        $.ajax({
            url: '//pirare.jupiterflow.com/modules/common/email-send.php', // url where upload the image
            type: 'POST',
            data: datas,
            dataType: 'json',
            success: function (jsonResult) {
                switch(jsonResult.success){
                    case true:
                        alert("문의 이메일이 발송되었습니다.");
                        location.reload();
                        break;
                    case false:
                        alert("문의 이메일 발송에 실패했습니다.");
                        break;
                    default:
                        break;
                }
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });
});

