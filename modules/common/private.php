<head>
    <link rel="stylesheet" href="../_style/mainStyle.css">
    <link rel="stylesheet" href="private.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
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
$email = $_SESSION['pir_user_email'];
$queryResult = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$email';"));
$pir_member_sort = $queryResult['member_sort'];
?>
<div id="contentWrap">

    <div id="screenFilter"></div>
    <div style="width:50%;margin:100px auto 50px auto;">
        <div class="contents-title">수집하는 개인정보</div>
        <p>
            PIRARE가 제공하는 대부분의 서비스들은 회원가입을 하지 않고서도 이용이 가능합니다.<br>
            회원가입을 하시는 경우, 로그인하여 개인화 서비스를 비롯한 다양한 회원제 기반의 서비스들을 이용하실 수 있습니다.<br>
            PIRARE는 회원가입 과정에서 서비스 이용을 위해 필요한 최소한의 정보만을 수집 및 활용합니다. 이러한 이유로 개인화 서비스 등의 일부 서비스에서는 이용자의 동의를 받아 개인정보를 추가로 수집하는 경우도 있습니다.
        </p>
        <br>
        <div class="contents-title">개인정보 수집 방법</div>
        <p>
            PIRARE는 홈페이지 등에서 이용자로부터 직접 입력 받는 방식으로 개인정보를 수집합니다.<br>
            개인정보의 수집이 발생하는 경우(생성정보 등 일부 예외를 제외하고) PIRARE는 이용자로부터 ‘개인정보 수집 및 이용에 대한 동의’를 얻으며 그 동의 범위 내에서만 개인정보를 이용합니다.
        </p>
        <br>
        <div class="contents-title">수집한 개인정보의 이용</div>
        <p>
            PIRARE는 회원님께 사전에 동의 받은 이용 목적과 달리 개인정보를 활용하지 않습니다.<br>
            수집한 회원의 개인정보를 회원관리, PIRARE 서비스의 제공 · 향상, 신규 서비스의 개발 및 안전한 인터넷 이용환경 구축 등의 목적에 한해 이용합니다.
        </p>
        <br>
        <div class="contents-title">개인정보의 제공 및 위탁</div>
        <p>
            PIRARE는 원칙적으로 이용자의 사전 동의 없이 개인정보를 외부에 제공하지 않습니다.<br>
            관계 법령에 의해 예외적으로 제3자에게 제공 의무가 발생하는 경우 해당 법령을 엄격히 해석하여 준수하며 이용자의 프라이버시 침해가 최소화되도록 노력합니다. 이에 관한 이용자의 문의에 성실히 답변할 것입니다.
        </p>
        <br>
        <div class="contents-title">개인정보의 파기</div>
        <p>
            개인정보의 수집 및 이용 목적이 달성 되면, 수집한 개인정보를 신속하고 안전한 방법으로 파기합니다.<br>
            '개인정보 유효기간제'에 따라 원칙적으로 1년간 서비스를 이용하지 않은 회원의 개인정보는 별도 분리하여 보관 · 관리합니다.
        </p>
        <br>
        <div class="contents-title">이용자 및 법정 대리인의 권리와 행사 방법</div>
        <p>
            PIRARE는 정보통신망법 및 개인정보 보호법 등 관계 법령에서 규정하고 있는 이용자의 권리를 충실히 보장합니다.<br>
            이용자는 언제든지 자신의 개인정보 및 이용 현황을 상시 확인할 수 있으며, 동의 철회 및 정정 요청을 할 수 있습니다. 만 14세 미만 아동에 대한 법정 대리인의 권리 또한 법령에 따라 보장됩니다.
        </p>
        <br>
        <div class="contents-title">개인정보 처리방침 변경 시 고지 의무</div>
        <p>
            개인정보 처리방침의 변경이 있는 경우 사전에 홈페이지 공지사항을 통해 이용자에게 고지합니다.
        </p>
    </div>
</div>


<?php require '../../includeLayout/footer.php'; ?>
</body>

