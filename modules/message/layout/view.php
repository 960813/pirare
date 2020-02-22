<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="view.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="view.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>
</head>
<body>
<?php require '../../../includeLayout/header.php'; ?>
<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
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
</div>
<div id="message-view">
    <div class="form">
        <div style="height:45px;">
            <div id="message-top-txt">
                <a href="javascript:location.reload()">수신 쪽지</a>
            </div>
            <div id="message-top-ref">답장</div>
            <div id="message-top-ref">목록</div>
        </div>
        <label for="message_target">보낸 사람</label>
        <input type="text" name="message_target" id="message_target" readonly>
        
        <label for="message_registered">보낸 날짜</label>
        <input type="text" name="message_registered" id="message_registered" readonly>

        <label for="message_subject">제목</label>
        <input type="text" name="message_subject" id="message_subject" readonly>

        <label for="message_body">내용</label>
        <textarea name="message_body" id="message_body" readonly></textarea>
    </div>

</div>

<?php require '../../../includeLayout/footer.php'; ?>
</body>

