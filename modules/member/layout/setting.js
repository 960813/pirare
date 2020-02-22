$(window).on("load", function () {


    $(".form button").on('click', function () {
        const checkedRadioButton = $('input[name=sortRadio]:checked');
        let updateSettingDatas;

        updateSettingDatas = new FormData();
        updateSettingDatas.append('sort',String(checkedRadioButton.val()));

        $.ajax({
            url: '../api/updateSetting.php',
            type: 'POST',
            dataType: 'json',
            data: updateSettingDatas,
            success: function (data) {
                alert(data.msg);
                // console.log(data);
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        }).then(r => function () {
            return 0;
        });


    });
});
