<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="list.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="list.js"></script>
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
    <div class="form">
        <div style="height:45px;">
            <div id="message-top-txt">
                <a href="list.php?type=recv">수신함</a>
                <a href="list.php?type=send">발신함</a>
            </div>
            <div id="message-top-ref">
                <a href='./send.php'>쪽지 발송</a>
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>보낸사람</th>
                <th>제목</th>
                <th>날짜</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div style="height:30px">
            <div id="messageDeleteBtn">삭제</div>
        </div>

    </div>

</div>


<?php require '../../../includeLayout/footer.php'; ?>
</body>

