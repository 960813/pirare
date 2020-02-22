<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
if (isset($_SESSION['pir_user_email'])) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_email='$pir_user_email'"))['member_no'];

    $type = $_GET['type'];
    $message_no = $_GET['no'];
    $sql = "SELECT * FROM `pir_messages` WHERE message_no='$message_no'";

    $row = mysqli_fetch_array(mysqli_query($dbconn, $sql));
    if($type=='recv') {
        if ($row['message_recv_del'] == 'Y') {
            $result['error'] = '삭제된 메시지는 열람할 수 없습니다.';
        } else if ($row['message_recv_id'] != $pir_user_no) {
            $result['error'] = '본인이 받은 쪽지만 열람할 수 있습니다.';
        } else {
            $result['success'] = true;
            $result['message_no'] = $row['message_no'];
            $sender_id = $row['message_sent_id'];
            $result['message_target_no'] = $sender_id;
            $result['message_target_nick'] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$sender_id'"))['member_nickname'];

            $result['message_subject'] = $row['message_subject'];
            $result['message_body'] = $row['message_body'];
            $result['message_registered'] = $row['message_registered'];
        }
    }else if($type=='send'){
        if ($row['message_send_del'] == 'Y') {
            $result['error'] = '삭제된 메시지는 열람할 수 없습니다.';
        } else if ($row['message_sent_id']!=$pir_user_no) {
            $result['error'] = '본인이 보낸 쪽지만 열람할 수 있습니다.';
        } else {
            $result['success'] = true;
            $result['message_no'] = $row['message_no'];
            $receiver_id = $row['message_recv_id'];
            $result['message_target_no'] = $receiver_id;
            $result['message_target_nick'] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$receiver_id'"))['member_nickname'];

            $result['message_subject'] = $row['message_subject'];
            $result['message_body'] = $row['message_body'];
            $result['message_registered'] = $row['message_registered'];
        }
    }

} else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
?>