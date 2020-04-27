<?php
if(!isset($_SESSION))
{
    session_start();
}
$exp = 60 * 60 * 24;// 1 day
//if (isset($_COOKIE['recentSearch']) && $_COOKIE['recentSearch'] - time() < $exp * 30) {
if (isset($_COOKIE['recentSearch'])) {
    setcookie("recentSearch", "", time() - 3600, '/'); //만료시간을 3600초 전으로 셋팅하여 확실히 제거
    setcookie('recentSearch', $_COOKIE['recentSearch'], time() + $exp * 365, '/');
}
$searchType = 'fetch';
$searchQuery = '';
if (isset($_GET['type']) && isset($_GET['query'])) {
    $searchType = $_GET['type'];
    $searchQuery = $_GET['query'];
    if ($searchType == 'search' || $searchType == 'bundle') {
        $recentKeywords = array_values(array_filter(array_map('trim', explode(',', $_COOKIE['recentSearch']))));

        if (!in_array($searchQuery, $recentKeywords))
            array_push($recentKeywords, $searchQuery);

        setcookie("recentSearch", "", time() - 3600, '/'); //만료시간을 3600초 전으로 셋팅하여 확실히 제거
        setcookie('recentSearch', implode(',', $recentKeywords), time() + $exp * 365, '/');
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        $(window).on("load", function () {
            $(".HeaderMenu1 svg").on('click', function () {
                location.href = '//pirare.jupiterflow.com/modules/bundle/layout/bundleList.php';
            });
            $(".HeaderMenu2 svg").on('click', function () {
                location.href = '//pirare.jupiterflow.com/modules/message/layout/list.php';
            });
            $(".HeaderMenu3 svg").on('click', function () {
                location.href = '//pirare.jupiterflow.com/modules/member/layout/profile.php';
            });
            $(".HeaderMenu4 svg").on("click", function () {
                $(".scrollMenu").fadeToggle(200);
                // $(".scrollMenu").hide(1000);
            });
            $(".searchInputBox").on("focus", function () {
                $(".HeaderSearchSection").css("box-shadow", " 0 0 0 4px rgba(0, 132, 255, .5)");
                $(".searchRecommendArea").show();
                $("#contentWrap #screenFilter").show();
                // $("body").css("background-color","rgba(0,0,0,.3)");

                $(".searchHistorySection span").on("click", function () {
                    const host = location.protocol + '//' + location.host;
                    window.location.href = host + '?type=search&query=' + $(this).html();
                });

            });
            $(".searchHistory > span > a").on('click', function (e) {
                e.preventDefault();
                if (!confirm("검색 기록을 모두 삭제하시겠습니까?"))
                    return;
                $.ajax({
                    url: 'modules/common/clearSearchHistory.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        alert("검색 기록을 모두 삭제하였습니다.");
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('ERRORS: ' + textStatus);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
            $("#contentWrap #screenFilter").on("mouseover", function () {
                console.log('mouseover');
                $(".HeaderSearchSection").css("box-shadow", " 0 0 0 4px rgba(0, 132, 255, .5)");
                $(".searchRecommendArea").show();
            });

            $("#contentWrap #screenFilter").on("click", function () {
                $(".HeaderSearchSection ").css("box-shadow", "none");
                $(".searchRecommendArea").hide();
                $("#contentWrap #screenFilter").hide();
            });

            $(".searchInputBox").on('keyup', function (e) {
                console.log($(this).val());
                console.log(e);
                if (e.keyCode === 13) {
                    const host = location.protocol + '//' + location.host;
                    window.location.href = host + '?type=search&query=' + $(this).val();
                }
            });

        });
    </script>
    <title>PIRARE</title>
</head>
<body>
<div class="HeaderSection">
    <div class="HeaderContent divFlex">
        <div class="HeaderLogo divFlex">
            <a href="//pirare.jupiterflow.com">
                <svg class="HeaderLogoSVG svgFill" height="40" width="40" viewBox="0 0 24 24" aria-hidden="true"
                     aria-label="" role="img">
                    <path d="M0 12c0 5.123 3.211 9.497 7.73 11.218-.11-.937-.227-2.482.025-3.566.217-.932 1.401-5.938 1.401-5.938s-.357-.715-.357-1.774c0-1.66.962-2.9 2.161-2.9 1.02 0 1.512.765 1.512 1.682 0 1.025-.653 2.557-.99 3.978-.281 1.189.597 2.159 1.769 2.159 2.123 0 3.756-2.239 3.756-5.471 0-2.861-2.056-4.86-4.991-4.86-3.398 0-5.393 2.549-5.393 5.184 0 1.027.395 2.127.889 2.726a.36.36 0 0 1 .083.343c-.091.378-.293 1.189-.332 1.355-.053.218-.173.265-.4.159-1.492-.694-2.424-2.875-2.424-4.627 0-3.769 2.737-7.229 7.892-7.229 4.144 0 7.365 2.953 7.365 6.899 0 4.117-2.595 7.431-6.199 7.431-1.211 0-2.348-.63-2.738-1.373 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0 0 5.373 0 12"></path>
                </svg>
            </a>
        </div>

        <div class="HeaderSearchSection divFlex setFlex" style="/*min-width:407px;*/">
            <div class="HeaderSearch_btn_ico">
                <svg class="HeaderSearchSVG dsBlock" height="20" width="20" viewBox="0 0 24 24" aria-label="검색 아이콘"
                     role="img">
                    <path d="M10 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6m13.12 2.88l-4.26-4.26A9.842 9.842 0 0 0 20 10c0-5.52-4.48-10-10-10S0 4.48 0 10s4.48 10 10 10c1.67 0 3.24-.41 4.62-1.14l4.26 4.26a3 3 0 0 0 4.24 0 3 3 0 0 0 0-4.24"></path>
                </svg>
            </div>
            <input type="text" class="searchInputBox" placeholder="검색" value="<?= $searchQuery ?>">

            <div class="searchRecommendArea">
                <div class="searchHistory">
                    <span>최근 검색어(<a href="#">모두 삭제</a>)</span>
                    <div class="searchHistorySection">
                        <?php
                        if(isset($_COOKIE['recentSearch'])) {
                            $recentKeywords = array_values(array_filter(array_map('trim', explode(',', $_COOKIE['recentSearch']))));

                            for ($i = 0; $i < count($recentKeywords); $i++) {
                                echo "<span>" . $recentKeywords[$i] . "</span>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>


        <div class="HeaderMenu1 divFocus divRound">
            <svg class="svgFill cl8e8e8e ml16 dsBlock" height="22" viewBox="0 0 480 480" width="22"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="m240 0c-132.546875 0-240 107.453125-240 240s107.453125 240 240 240 240-107.453125 240-240c-.148438-132.484375-107.515625-239.851562-240-240zm0 464c-123.710938 0-224-100.289062-224-224s100.289062-224 224-224 224 100.289062 224 224c-.140625 123.652344-100.347656 223.859375-224 224zm0 0"/>
                <path d="m344 96h-208c-22.082031.027344-39.972656 17.917969-40 40v208c.027344 22.082031 17.917969 39.972656 40 40h208c22.082031-.027344 39.972656-17.917969 40-40v-208c-.027344-22.082031-17.917969-39.972656-40-40zm24 248c0 13.253906-10.746094 24-24 24h-208c-13.253906 0-24-10.746094-24-24v-208c0-13.253906 10.746094-24 24-24h208c13.253906 0 24 10.746094 24 24zm0 0"/>
                <path d="m240 160c-44.183594 0-80 35.816406-80 80s35.816406 80 80 80 80-35.816406 80-80c-.046875-44.164062-35.835938-79.953125-80-80zm0 144c-35.347656 0-64-28.652344-64-64s28.652344-64 64-64 64 28.652344 64 64c-.039062 35.328125-28.671875 63.960938-64 64zm0 0"/>
                <path d="m328 128c-13.253906 0-24 10.746094-24 24s10.746094 24 24 24 24-10.746094 24-24-10.746094-24-24-24zm0 32c-4.417969 0-8-3.582031-8-8s3.582031-8 8-8 8 3.582031 8 8-3.582031 8-8 8zm0 0"/>
            </svg>
        </div>
        <div class="HeaderSpliter"></div>
        <?php
        if (isset($_SESSION['pir_user_email'])) {
            ?>
            <div class="HeaderMenu2 divFocus divRound">
                <svg class="svgFill ml16 cl8e8e8e dsBlock" height="24" width="24" viewBox="0 0 24 24" aria-hidden="true"
                     aria-label="" role="img">
                    <path d="M18 12.5a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18 12.5m-6 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 12 12.5m-6 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 6 12.5M12 0C5.925 0 1 4.925 1 11c0 2.653.94 5.086 2.504 6.986L2 24l5.336-3.049A10.93 10.93 0 0 0 12 22c6.075 0 11-4.925 11-11S18.075 0 12 0"></path>
                </svg>
            </div>
            <div class="HeaderMenu3 divFocus divRound">
                <!--            <svg class="svgFill cl8e8e8e ml36 dsBlock" width="24" height="24" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path fill="#8e8e8e" d="M8 16c-1.12 0-2.03-.9-2.03-2h4.06c0 1.1-.91 2-2.03 2zm4.72-6.92c1.02.95 1.74 2.19 2.03 3.59H1.25c.29-1.4 1.01-2.64 2.02-3.59V4.67C3.27 2.09 5.39 0 8 0c2.61 0 4.72 2.09 4.72 4.67v4.41z"></path></svg>-->
                <svg class="svgFill cl8e8e8e ml16 dsBlock" width="24" height="24" viewBox="0 0 55 55">
                    <path d="M55,27.5C55,12.337,42.663,0,27.5,0S0,12.337,0,27.5c0,8.009,3.444,15.228,8.926,20.258l-0.026,0.023l0.892,0.752 c0.058,0.049,0.121,0.089,0.179,0.137c0.474,0.393,0.965,0.766,1.465,1.127c0.162,0.117,0.324,0.234,0.489,0.348 c0.534,0.368,1.082,0.717,1.642,1.048c0.122,0.072,0.245,0.142,0.368,0.212c0.613,0.349,1.239,0.678,1.88,0.98 c0.047,0.022,0.095,0.042,0.142,0.064c2.089,0.971,4.319,1.684,6.651,2.105c0.061,0.011,0.122,0.022,0.184,0.033 c0.724,0.125,1.456,0.225,2.197,0.292c0.09,0.008,0.18,0.013,0.271,0.021C25.998,54.961,26.744,55,27.5,55 c0.749,0,1.488-0.039,2.222-0.098c0.093-0.008,0.186-0.013,0.279-0.021c0.735-0.067,1.461-0.164,2.178-0.287 c0.062-0.011,0.125-0.022,0.187-0.034c2.297-0.412,4.495-1.109,6.557-2.055c0.076-0.035,0.153-0.068,0.229-0.104 c0.617-0.29,1.22-0.603,1.811-0.936c0.147-0.083,0.293-0.167,0.439-0.253c0.538-0.317,1.067-0.648,1.581-1 c0.185-0.126,0.366-0.259,0.549-0.391c0.439-0.316,0.87-0.642,1.289-0.983c0.093-0.075,0.193-0.14,0.284-0.217l0.915-0.764 l-0.027-0.023C51.523,42.802,55,35.55,55,27.5z M2,27.5C2,13.439,13.439,2,27.5,2S53,13.439,53,27.5 c0,7.577-3.325,14.389-8.589,19.063c-0.294-0.203-0.59-0.385-0.893-0.537l-8.467-4.233c-0.76-0.38-1.232-1.144-1.232-1.993v-2.957 c0.196-0.242,0.403-0.516,0.617-0.817c1.096-1.548,1.975-3.27,2.616-5.123c1.267-0.602,2.085-1.864,2.085-3.289v-3.545 c0-0.867-0.318-1.708-0.887-2.369v-4.667c0.052-0.52,0.236-3.448-1.883-5.864C34.524,9.065,31.541,8,27.5,8	s-7.024,1.065-8.867,3.168c-2.119,2.416-1.935,5.346-1.883,5.864v4.667c-0.568,0.661-0.887,1.502-0.887,2.369v3.545	c0,1.101,0.494,2.128,1.34,2.821c0.81,3.173,2.477,5.575,3.093,6.389v2.894c0,0.816-0.445,1.566-1.162,1.958l-7.907,4.313 c-0.252,0.137-0.502,0.297-0.752,0.476C5.276,41.792,2,35.022,2,27.5z"/>
                </svg>
            </div>
            <?php
        }
        ?>
        <div class="HeaderMenu4 divFocus divRound">
            <svg class="svgFill cl8e8e8e ml16 mr24 dsBlock" height="22" width="22" viewBox="0 0 24 24"
                 aria-hidden="true" aria-label="" role="img">
                <path d="M12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3M3 9c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm18 0c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3z"></path>
            </svg>

            <div class="scrollMenu">

                <?php
                if (isset($_SESSION['pir_user_email'])) {
                    ?>
                    <div class="scrollMenu_item">
                        <a href="//pirare.jupiterflow.com/modules/member/layout/setting.php">설정</a>
                        <hr class="HeaderLine">
                    </div>
                    <div class="scrollMenu_item">
                        <a href="//pirare.jupiterflow.com/modules/common/email-contact.php">문의</a>
                        <hr class="HeaderLine">
                    </div>
                    <div class="scrollMenu_item">
                        <a href="//pirare.jupiterflow.com/modules/member/api/signout.php">로그아웃</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="scrollMenu_item">
                        <a href="//pirare.jupiterflow.com/modules/member/layout/yidlogin.php">로그인 / 회원가입</a>
                    </div>
                    <?php
                }
                ?>


            </div>

        </div>

    </div>
    <hr class="HeaderLine">
</div>
</body>