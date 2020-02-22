<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
if (isset($_SESSION['pir_user_email']) || isset($_POST)) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $sender_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT member_no FROM `pir_members` WHERE member_email='$pir_user_email'"))[0];

    $receiver_no = explode(',', $_POST['receiver']);
    $message_subject = $_POST['subject'];
    $message_body = $_POST['body'];

    foreach ($receiver_no as $key => $value) {
        $selectedReceiverNo = mysqli_fetch_array(mysqli_query($dbconn, "SELECT member_no FROM `pir_members` WHERE member_nickname='$value'"))[0];
        $rs = mysqli_query($dbconn, "INSERT INTO `pir_messages` (message_recv_id,message_sent_id,message_subject,message_body) VALUES ('$selectedReceiverNo','$sender_no','$message_subject','$message_body')");
        $result['test'] = $rs;
        $result['success'] = true;
    }

} else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
?>