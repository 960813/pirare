$(window).on("load", function () {


    $(".form button").on('click', function () {
        const user_email = $("input[name=user_email]");
        const user_pw = $("input[name=user_pw]");
        if (user_email.val() === "") {
            alert("이메일 주소를 입력해주세요.");
            user_email.trigger('focus');
            return false;
        } else if (user_pw.val() === "") {
            alert("비밀번호를 입력해주세요.");
            user_pw.trigger('focus');
            return false;
        }
        if (confirm("정말 회원탈퇴 하시겠습니까?")) {
            const post_data = new FormData();

            post_data.append('user_email', user_email.val());
            post_data.append('user_pw', user_pw.val());

            $.ajax({
                url: '../api/signin.php',
                type: 'POST',
                dataType: 'json',
                data: post_data,
                success: function (data) {
                    switch (data.status) {
                        case true:
                            $.ajax({
                                url: '../api/dropout.php',
                                type: 'POST',
                                dataType: 'json',
                                data: post_data,
                                success: function (data2) {
                                    switch (data2.success) {
                                        case true:
                                            alert("회원탈퇴에 성공하였습니다.");
                                            location.href = "//pirare.jupiterflow.com";
                                            break;
                                        case false:
                                            alert(data2.error);
                                            break;
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                            break;
                        case false:
                            alert(data.msg);
                            break;
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});
