let pwchangeflag = false;

function requestModifyMember(datas){
    $.ajax({
        url: '../api/modifyMember.php',
        type: 'POST',
        dataType: 'json',
        data: datas,
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
    }).then(r => function(){
        return 0;
    });
}

$(window).on("load",function(){
    $('label a').on('click',function() {
        $('#pwchange').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
        pwchangeflag = !pwchangeflag;
    });

    $(".form button").on('click',function(){
        const emailtxt =        $(".form > input:nth-of-type(1)");
        const pwtxt =           $(".form > input:nth-of-type(2)");
        const pwchange1txt =    $(".form > #pwchange > input:nth-of-type(1)");
        const pwchange2txt =    $(".form > #pwchange > input:nth-of-type(2)");
        const nicktxt =         $(".form > input:nth-of-type(3)");


        if (!pwtxt.val()) {
            alert("암호를 입력해주세요!");
            pwtxt.trigger('focus');
            return false;
        }else if (!nicktxt.val()){
            alert("닉네임을 입력해주세요!");
            nicktxt.trigger('focus');
            return false;
        }else{
            if(pwchangeflag){
                if (!pwchange1txt.val()) {
                    alert("변경할 암호를 입력해주세요!");
                    pwchange1txt.trigger('focus');
                    return false;
                }else if (!pwchange2txt.val()) {
                    alert("변경할 암호를 재입력해주세요!");
                    pwchange2txt.trigger('focus');
                    return false;
                }else if (pwchange1txt.val() === pwchange2txt.val()){
                    // alert("두 암호 일치");
                    let pwchangeDatas;

                    pwchangeDatas = new FormData();
                    pwchangeDatas.append('emailtxt',emailtxt.val().toString());
                    pwchangeDatas.append('pwtxt',pwtxt.val().toString());
                    pwchangeDatas.append('pwchangeflag',pwchangeflag);
                    pwchangeDatas.append('pwchange1txt',pwchange1txt.val().toString());
                    pwchangeDatas.append('pwchange2txt',pwchange2txt.val().toString());
                    pwchangeDatas.append('nicktxt',nicktxt.val().toString());
                    requestModifyMember(pwchangeDatas);

                }else {
                    alert("변경할 암호가 서로 일치하지 않습니다.");
                    pwchange2txt.trigger('focus');
                }
            }else{
                // alert("일반 수정");
                let normalDatas;

                normalDatas = new FormData();
                normalDatas.append('emailtxt',emailtxt.val().toString());
                normalDatas.append('pwtxt',pwtxt.val().toString());
                normalDatas.append('pwchangeflag',pwchangeflag);
                normalDatas.append('pwchange1txt',"");
                normalDatas.append('pwchange2txt',"");
                normalDatas.append('nicktxt',nicktxt.val().toString());
                requestModifyMember(normalDatas);

                //암호 입력 완료. 입력한 이메일-암호 쌍이 맞는지 확인 후 닉네임 변경
            }
        }

    });
});
