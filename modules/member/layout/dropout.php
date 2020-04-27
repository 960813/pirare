<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="dropout.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="dropout.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>
</head>
<body>
<?php require '../../../includeLayout/header.php'; ?>
<?php
if(!isset($_SESSION))
{
    session_start();
}
if (!isset($_SESSION['pir_user_email']) || empty($_SESSION['pir_user_email'])) {
    echo '<script>
            alert("로그인이 필요한 페이지입니다.");
            location.href = "//pirare.jupiterflow.com/modules/member/layout/yidlogin.php";
        </script>';
}
?>
<div id="contentWrap">
    <div id="screenFilter"></div>
    <div class="form">
        <input type="email" name="user_email" placeholder="이메일 주소" readonly value="<?=$_SESSION['pir_user_email']?>">
        <input type="password" name="user_pw" placeholder="비밀번호">
        <button>회원탈퇴</button>
    </div>
</div>
<?php require '../../../includeLayout/footer.php'; ?>
</body>

