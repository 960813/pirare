<head>
    <link rel="stylesheet" href="../_style/mainStyle.css">
    <link rel="stylesheet" href="email-contact.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="email-contact.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>
</head>
<body>
<?php require '../../includeLayout/header.php'; ?>
<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../_configure/dbconn.php');
header('Content-type: application/json;');
?>
<?php
if (!isset($_SESSION['pir_user_email']) || empty($_SESSION['pir_user_email'])) {
    echo '<script>
            alert("로그인이 필요한 페이지입니다.");
            location.href = "//pirare.jupiterflow.com/modules/member/layout/yidlogin.php";
        </script>';
}
?>
<?php
$email = $_SESSION['pir_user_email'];
$queryResult = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$email';"));
$pir_member_sort = $queryResult['member_sort'];
?>
<div id="contentWrap">

    <div id="screenFilter"></div>
    <div class="contact-form">
        <label for="contact-type-list">문의 카테고리</label>
        <select name="contact-type-list">
            <option value="이용문의">이용문의</option>
            <option value="제휴문의">제휴문의</option>
            <option value="기타문의">기타문의</option>
        </select>

        <label for="contact-customer-body">문의 내용</label>
        <textarea name="contact-customer-body" placeholder="내용 입력.." style="height:200px"></textarea>

        <input type="button" value="문의하기">
    </div>
</div>


<?php require '../../includeLayout/footer.php'; ?>
</body>

