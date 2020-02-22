<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
require_once($HOME_DIR . '../../_configure/recaptcha.php');
?>
<?php
session_start();
$response_array['title'] = 'Inspirare JSON Response[signin.php]';
if (isset($_POST["user_email"]) && isset($_POST["user_pw"])) {
    $user_email = $_POST["user_email"];
    $user_pw = $_POST["user_pw"];

    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = $recaptcha_secretKey;
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        $sql = "SELECT * FROM `pir_members` WHERE member_email='$user_email'";
        $rs = mysqli_query($dbconn, $sql);

        if (mysqli_num_rows($rs) > 0) {
            $row = mysqli_fetch_array($rs);
            if (password_verify($user_pw, $row['member_pw'])) {
                $response_array['status'] = true;
                $response_array['msg'] = '로그인 성공';
                $_SESSION['pir_user_email'] = $user_email;
            } else {
                $response_array['status'] = false;
                $response_array['msg'] = '비밀번호가 일치하지 않습니다.';
            }
        } else {
            $response_array['status'] = false;
            $response_array['msg'] = '등록되지 않은 아이디입니다.';
        }
    } else {
        $response_array['status'] = false;
        $response_array['msg'] = '정상적인 경로가 아닙니다.';
    }
} else {
    $response_array['status'] = false;
    $response_array['msg'] = '입력 값이 유효하지 않습니다.';
}
echo json_encode($response_array);
?>
