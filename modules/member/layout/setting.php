<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <link rel="stylesheet" href="setting.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="setting.js"></script>
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
<?php
$email = $_SESSION['pir_user_email'];
$queryResult = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$email';"));
$pir_member_sort = $queryResult['member_sort'];
?>
<div id="contentWrap">

    <div id="screenFilter"></div>
    <div class="form">
        <label>메인화면 정렬 방법</label><br>
        <label class="sortRadio">
            <?php
            if($pir_member_sort=='desc') {
                ?>
                <input name="sortRadio" type="radio" value="desc" checked>최신 게시글부터
                <?php
            }else{
                ?>
                <input name="sortRadio" type="radio" value="desc">최신 게시글부터
                <?php
            }
            ?>
        </label>
        <label class="sortRadio">
            <?php
            if($pir_member_sort=='asc') {
                ?>
                <input name="sortRadio" type="radio" value="asc" checked>오래된 게시글부터
                <?php
            }else{
                ?>
                <input name="sortRadio" type="radio" value="asc">오래된 게시글부터
            <?php
            }
            ?>
        </label>
        <label class="sortRadio">
            <?php
            if($pir_member_sort=='rand') {
                ?>
                <input name="sortRadio" type="radio" value="rand" checked>랜덤
                <?php
            }else{
                ?>
                <input name="sortRadio" type="radio" value="rand">랜덤
                <?php
            }
            ?>
        </label>
        <label id="dropout">회원탈퇴<a href="//pirare.jupiterflow.com/modules/member/layout/dropout.php">(바로가기)</a></label>
        <button>저장</button>
    </div>
</div>


<?php require '../../../includeLayout/footer.php'; ?>
</body>

