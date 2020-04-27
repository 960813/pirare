<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="yidlogin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="yidlogin.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>

    <script src='https://www.google.com/recaptcha/api.js?render=6LcKue4UAAAAAC4swqcz6p5c4MLKDfMZLCSCBfoE'></script>
    <script type="text/javascript">
        grecaptcha.ready(function () {
            grecaptcha.execute('6LcKue4UAAAAAC4swqcz6p5c4MLKDfMZLCSCBfoE', {action: 'loginpage'})
                .then(function (token) {
                    const recapElem = $(".g-recaptcha-response");
                    $.each(recapElem, function(idx,vo){
                        $(this).val(token);
                    });
                });
        });
    </script>
</head>
<body>
<?php require '../../../includeLayout/header.php'; ?>
<div id="contentWrap">
    <div id="screenFilter"></div>
    <div class="form">
        <form class="register-form" onsubmit="return checkvalue(this,event);">
            <input type="email" name="user_email" placeholder="이메일 주소">
            <input type="password" name="user_pw" placeholder="비밀번호">
            <input type="password" name="user_pw2" placeholder="비밀번호 재입력">
            <input type="text" name="user_nick" placeholder="닉네임">
            <p class="private_alert">가입 시 <a href="#" target="_blank">개인정보처리방침</a>에 동의한것으로 간주합니다.</p>
            <button>가입</button>
            <p class="message">계정이 이미 있으신가요? <a href="#">로그인하기</a></p>
            <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
        </form>
        <form class="login-form" onsubmit="return checkvalue(this,event);">
            <input type="email" name="user_email" placeholder="이메일 주소">
            <input type="password" name="user_pw" placeholder="비밀번호">
            <button>로그인</button>
            <p class="message">계정이 없으신가요? <a href="#">회원가입 하기</a></p>
            <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
        </form>
    </div>
</div>
<?php require '../../../includeLayout/footer.php'; ?>
</body>

