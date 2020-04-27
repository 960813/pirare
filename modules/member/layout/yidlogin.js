let emailVerified = false;
let nickVerified = false;

function checkvalue(target, event) {
    const cN = target.className;
    event.preventDefault();
    if (cN === 'register-form') {

        const reg_form = $(".register-form");
        const user_email = reg_form.children("input[name=user_email]");
        const user_pw = reg_form.children("input[name=user_pw]");
        const user_pw2 = reg_form.children("input[name=user_pw2]");
        const user_nick = reg_form.children("input[name=user_nick]");

        if(!emailVerified){
            alert("사용할 수 없는 이메일입니다.");
            user_email.trigger('focus');
            return false;
        }
        if(!nickVerified){
            alert("사용할 수 없는 닉네임입니다.");
            user_nick.trigger('focus');
            return false;
        }

        if(user_nick.val().length>12){
            alert("닉네임은 12글자까지만 사용 가능합니다.");
            user_nick.trigger('focus');
            return false;
        }

        if (user_email.val() === "") {
            alert("이메일을 입력해주세요.");
            user_email.trigger('focus');
            return false;
        } else if (user_pw.val() === "") {
            alert("비밀번호를 입력해주세요.");
            user_pw.trigger('focus');
            return false;
        } else if (user_pw2.val() === "") {
            alert("비밀번호 확인을 입력해주세요.");
            user_pw2.trigger('focus');
            return false;
        } else if (user_nick.val() === "") {
            alert("닉네임을 입력해주세요.");
            user_nick.trigger('focus');
            return false;
        }

        if (user_pw.val() !== user_pw2.val()) {
            alert("입력된 비밀번호가 일치하지 않습니다.");
            user_pw.val('');
            user_pw2.val('');
            user_pw.trigger('focus');
            return false;
        }

        const post_data = $('.register-form').serialize();
        $.ajax({
            url: '../api/signup.php',
            type: 'POST',
            data: post_data,
            success: function (data) {
                const _status = data["status"];
                if (_status === true) {
                    $("form").each(function () {
                        if (this.className === "register-form") this.reset();
                    });
                    alert("회원가입에 성공하였습니다.");
                    $('form').animate({
                        height: "toggle",
                        opacity: "toggle"
                    }, "slow");
                    renewVerifyValue();
                } else {
                    console.log(data);
                    switch (data['error']['code']) {
                        case 1062:
                            alert("이미 가입된 이메일입니다.");
                            break;
                        case -1:
                            break;
                        default:
                            break;
                    }
                }
            }
        });

    } else if (cN === 'login-form') {
        const login_form = $(".login-form");
        const user_email = login_form.children("input[name=user_email]");
        const user_pw = login_form.children("input[name=user_pw]");
        if (user_email.val() === "") {
            alert("이메일 주소를 입력해주세요.");
            user_email.trigger('focus');
            return false;
        } else if (user_pw.val() === "") {
            alert("비밀번호를 입력해주세요.");
            user_pw.trigger('focus');
            return false;
        }
        const post_data = $('.login-form').serialize();
        $.ajax({
            url: '../api/signin.php',
            type: 'POST',
            dataType: 'json',
            data: post_data,
            success: function (data) {
                console.log(data);
                switch(data.status){
                    case true:
                        $("form").each(function () {
                            if (this.className === "login-form") this.reset();
                        });
                        window.location.replace("//pirare.jupiterflow.com");
                        break;
                    case false:
                        alert(data.msg);
                        break;
                }
            }
        });
    }

}
function renewVerifyValue(){
    grecaptcha.execute('6LcKue4UAAAAAC4swqcz6p5c4MLKDfMZLCSCBfoE', {action: 'loginpage'})
        .then(function (token) {
            const recapElem = $(".g-recaptcha-response");
            $.each(recapElem, function(idx,vo){
                $(this).val(token);
            });
        });

}
$(window).on("load", function () {
    $('.message a').on('click', function () {
        $('form').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
        renewVerifyValue();
    });

    $(".register-form input[name=user_email]").on('propertychange change keyup paste input', function (e) {
        const currentUserEmail = $(this).val();
        const fd = new FormData();
        fd.append('type', 'email');
        fd.append('txt', currentUserEmail);

        $.ajax({
            url: '//pirare.jupiterflow.com/modules/member/api/checkUser.php',
            type: 'POST',
            dataType: 'json',
            data: fd,
            success: function (data) {
                if (data.success) {
                    emailVerified = true;
                    $(e.target).css('background', '#f2f2f2');
                } else {
                    emailVerified = false;
                    $(e.target).css('background', '#ffc9c9');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $(".register-form input[name=user_nick]").on('propertychange change keyup paste input', function (e) {
        const currentUserNick = $(this).val();
        const fd = new FormData();
        fd.append('type', 'nick');
        fd.append('txt', currentUserNick);

        $.ajax({
            url: '//pirare.jupiterflow.com/modules/member/api/checkUser.php',
            type: 'POST',
            dataType: 'json',
            data: fd,
            success: function (data) {
                if (data.success) {
                    nickVerified = true;
                    $(e.target).css('background', '#f2f2f2');
                } else {
                    nickVerified = false;
                    $(e.target).css('background', '#ffc9c9');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});
