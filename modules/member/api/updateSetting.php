<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$sorttxt = $_POST['sort'];

$result['success'] = false;
session_start();
if (isset($_SESSION['pir_user_email'])) {
    $email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$email';"))['member_no'];

    $updateResult = mysqli_query($dbconn, "UPDATE `pir_members` SET member_sort='$sorttxt' WHERE member_no='$pir_user_no';");
    if ($updateResult) {
        $result['success'] = true;
        $result['msg'] = '설정 변경 성공';
    } else
        $result['msg'] = '설정 변경 실패';
} else
    $result['error'] = '정상적인 요청이 아닙니다.';
echo json_encode($result);
?>