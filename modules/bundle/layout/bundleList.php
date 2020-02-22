<!doctype html>
<html lang="ko">
<head>
    <link rel="stylesheet" href="../../_style/mainStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>


    <script src="../../_js/bundleList-init.js"></script>
    <script src="../../_js/resize.js"></script>
    <!--Favicon-->
    <link rel="shortcut icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <link rel="icon" href="//pirare.jupiterflow.com/vendor/favicon.ico">
    <title>PIRARE</title>
    <style>
        .bundle_txt{
            font-weight:bold;
            text-align: center;
        }
    </style>
</head>
<body>
<?php require '../../../includeLayout/header.php'; ?>
<?php
//$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
//require_once($HOME_DIR.'modules/_configure/dbconn.php');
//?>
<?php
//for($i=1;$i<=227;$i++){
//    if($i==104) continue;
//    $imgpath = 'https://pirare.jupiterflow.com/upload/PTR/960813_PTR('.$i.')-image.jpg';
//    echo mysqli_query($dbconn, "INSERT INTO pir_imgs(img_owner, img_path,img_thumb_path, img_msg) VALUES ('martin@jupiterflow.com','$imgpath','$imgpath','test')");
//
//}
//?>
<div id="contentWrap" style="padding: 89px 0 24px 0;">
    <div id="screenFilter"></div>
    <div class="gridCentered grid">
        <div class="grid-sizer"></div>
        <div id="pinPopup"></div>
    </div>

    <?php
    if(isset($_SESSION['pir_user_email'])) {
        echo '<div class="addPirButton">';
        echo '<div style="width:32px;height:32px;margin:13px;">';
        echo '<svg height="16" width="16" viewBox="0 0 24 24" aria-hidden="true" aria-label="" role="img"><path d="M22 10h-8V2a2 2 0 0 0-4 0v8H2a2 2 0 0 0 0 4h8v8a2 2 0 0 0 4 0v-8h8a2 2 0 0 0 0-4"></path></svg>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

<div id="addPirWrap">
    <div id="screenFilter"></div>

    <div id="addPirPopup">
        <div id="imgSection">

        </div>
        <div id="uploadCloud">

        </div>
        <div id="inputSection">
            <div style="width:0; height:0; overflow: hidden;">
                <input type="file" id="pirFileUpload">
            </div>
            <textarea placeholder="msg"></textarea>
            <input id="tagtxt" type="text" value="" placeholder="tag">
            <select id="bundletxt">

                <!--                번들 동적 Listing 기능 추가 필요-->
            </select>
            <!--            <input id="bundletxt" type="text" value="" placeholder="bundle">-->
            <button>등록</button>
        </div>
    </div>


</div>
</body>
</html>