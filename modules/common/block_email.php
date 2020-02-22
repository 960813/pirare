<head>
    <link rel="stylesheet" href="../_style/mainStyle.css">
    <link rel="stylesheet" href="block-email.css">
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
        <div class="contents-title">■ 이메일주소수집거부</div>
        <p>
            본 웹사이트에 게시된 이메일 주소가 전자우편 수집 프로그램이나 그 밖의 기술적 장치를 이용하여 무단으로 수집되는 것을 거부하며, 이를 위반시 정보통신망법에 의해 형사처벌됨을 유념하시기 바랍니다.
            「정보통신망 이용촉진 및 정보보호 등에 관한 법률」 [시행 2013.3.23] [법률 제11690호, 2013.3.23, 타법개정]
        </p>
        <br><br>
        <div class="contents-title">제50조의2 (전자우편주소의 무단 수집행위 등 금지)</div>
        <p>
            누구든지 인터넷 홈페이지 운영자 또는 관리자의 사전 동의 없이 인터넷 홈페이지에서 자동으로 전자우편주소를 수집하는 프로그램이나 그 밖의 기술적 장치를 이용하여 전자우편주소를 수집하여서는
            아니된다.<br><br>
            누구든지 제1항을 위반하여 수집된 전자우편주소를 판매 · 유통하여서는 아니된다.<br><br>
            누구든지 제1항과 제2항에 따라 수집 · 판매 및 유통이 금지된 전자우편주소임을 알면서 이를 정보 전송에 이용하여서는 아니된다.[전문개정 2008.6.13]
        </p>
        <br><br>
        <div class="contents-title">제74조 (벌칙)</div>
        <p>
            다음 각 호의 어느 하나에 해당하는 자는 1년 이하의 징역 또는 1천만원 이하의 벌금에 처한다.
        </p>
        <ol>
            <li>제8조제4항을 위반하여 비슷한 표시를 한 제품을 표시 · 판매 또는 판매할 목적으로 진열한 자</li>
            <li>제44조의7제1항제1호의 규정을 위반하여 음란한 부호 · 문언 · 음향 · 화상 또는 영상을 배포 · 판매 · 임대하거나 공공연하게 전시한 자</li>
            <li>제44조의7제1항제3호의 규정을 위반하여 공포심이나 불안감을 유발하는 부호 · 문언 · 음향 · 화상 또는 영상을 반복적으로 상대방에게 도달하게 한 자</li>
            <li>제50조제6항의 규정을 위반하여 기술적 조치를 한 자</li>
            <li>제50조의2를 위반하여 전자우편 주소를 수집 · 판매 · 유통하거나 정보 전송에 이용한 자</li>
            <li>제50조의8을 위반하여 광고성 정보를 전송한 자</li>
            <li>제53조제4항을 위반하여 등록사항의 변경등록 또는 사업의 양도 · 양수 또는 합병 · 상속의 신고를 하지 아니한 자</li>
        </ol>
        <br>
        <p>
            제1항제3호의 죄는 피해자가 구체적으로 밝힌 의사에 반하여 공소를 제기할 수 없다.[전문개정 2008.6.13]
        </p>
    </div>
</div>


<?php require '../../includeLayout/footer.php'; ?>
</body>

