<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="send.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="send.js"></script>
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
</div>
<div id="message-view">
    <div id="screenFilter"></div>
    <div id="message-member-list">
        <div id="message-top-txt" style="width:100%;">
            회원 목록
        </div>
        <hr style="margin-top:30px; border-top:1px solid black; border-bottom:0; border-left:0;">
        <table>
            <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>회원</th>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
        <input id="message-member-submit" type="button" value="저장">
    </div>
    <div class="form">
        <div style="height:45px;">
            <div id="message-top-txt">
                <a href="javascript:location.reload()">쪽지 발송</a>
            </div>
            <div id="message-top-ref"><a href="list.php?type=recv">목록</a></div>
        </div>
        <input type="text" id="message_receiver" placeholder="받는 사람" readonly><input id="messageSearchBtn" type="button"
                                                                            value="검색">
        <input type="text" id="message_subject" placeholder="쪽지 제목">
        <textarea id="message_body" placeholder="쪽지 내용"></textarea>
        <input id="messageSendBtn" type="button" value="발송">
    </div>

</div>

<?php require '../../../includeLayout/footer.php'; ?>
</body>

