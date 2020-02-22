<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$emailtxt = $_POST['emailtxt'];
$pwtxt = $_POST['pwtxt'];
$pwchangeflag = $_POST['pwchangeflag'];
$pwchange1txt = $_POST['pwchange1txt'];
$pwchange2txt = $_POST['pwchange2txt'];
$nicktxt = $_POST['nicktxt'];

$result['success'] = false;
session_start();
if (isset($_SESSION['pir_user_email']) and $_SESSION['pir_user_email'] === $emailtxt) {
    $email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$email';"))['member_no'];

    $rs = mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$pir_user_no';");
    $row = mysqli_fetch_array($rs);
    if (password_verify($pwtxt, $row['member_pw'])) {
        if ($pwchangeflag === "true") {
            // 비밀번호 변경
//            $updateResult = myqli_query($dbconn,"UPDATE FROM `pir_member` SET ``")
            if ($pwchange1txt === $pwchange2txt) {
                $updateResult = mysqli_query($dbconn, "UPDATE `pir_members` SET member_nickname='$nicktxt', member_pw='" . password_hash($pwchange1txt, PASSWORD_DEFAULT, ["cost" => 12]) . "' WHERE member_no='$pir_user_no';");
                if ($updateResult) {
                    $result['success'] = true;
                    $result['msg'] = '회원정보 변경 성공';
                } else
                    $result['msg'] = '회원정보 변경 실패';
            } else
                $result['msg'] = '변경할 암호가 서로 일치하지 않습니다.';
        } else {
            // 비밀번호 변경 안함
            $updateResult = mysqli_query($dbconn, "UPDATE `pir_members` SET member_nickname='$nicktxt' WHERE member_no='$pir_user_no';");
            if ($updateResult) {
                $result['success'] = true;
                $result['msg'] = '회원정보 변경 성공';
            } else
                $result['msg'] = '회원정보 변경 실패';

        }
    } else {
        $result['msg'] = '현재 비밀번호가 일치하지 않습니다.';
    }
}else
    $result['error'] = '정상적인 요청이 아닙니다.';
echo json_encode($result);
?>