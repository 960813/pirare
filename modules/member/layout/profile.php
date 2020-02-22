<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="profile.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="profile.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>
</head>
<body>
<?php require '../../../includeLayout/header.php'; ?>
<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR.'../../_configure/dbconn.php');
?>
<?php
$email = $_SESSION['pir_user_email'];
$queryResult = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM `pir_members` WHERE `member_email` = '$email';"));
$pir_user_no = $queryResult['member_no'];
$nick =$queryResult["member_nickname"];
?>
<?php
session_start();
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
        <label for="emailtxt">이메일</label>
        <input name="emailtxt" type="email" value="<?=$email?>" disabled>

        <label for="pwtxt">암호(<a href="#">비밀번호변경</a>)</label>
        <input name="pwtxt" type="password" value="">

        <div id="pwchange">
            <label for="pwchange1txt">암호변경 입력</a></label>
            <input name="pwchange1txt" type="password" value="">
            <label for="pwchange2txt">암호변경 재입력</label>
            <input name="pwchange2txt" type="password" value="">
        </div>

        <label for="nicktxt">닉네임</label>
        <input name="nicktxt" type="text" value="<?=$nick?>">
        <button>수정</button>
    </div>
</div>



<?php require '../../../includeLayout/footer.php'; ?>
</body>

