<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
$user_email = $_POST['user_email'];
$user_pw = $_POST['user_pw'];
if(!isset($_SESSION))
{
    session_start();
}
if (isset($_SESSION['pir_user_email']) and $_SESSION['pir_user_email'] == $user_email) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$pir_user_email';"))['member_no'];

    $pir_user_data = mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_email='$user_email'");

    if (mysqli_num_rows($pir_user_data) > 0) {
        $row = mysqli_fetch_array($pir_user_data);
        if (password_verify($user_pw, $row['member_pw'])) {
            if (mysqli_query($dbconn, "DELETE FROM `pir_members` WHERE member_no='$pir_user_no'")) {
                $result['success'] = true;
                unset($_SESSION['pir_user_email']);
            } else
                $result['error'] = '회원탈퇴에 실패하였습니다.';
        } else {
            $result['error'] = '비밀번호가 일치하지 않습니다.';
        }
    }else
    $result['error'] = '회원정보가 일치하지 않습니다.';

} else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
?>