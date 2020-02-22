<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$type = $_GET['type'];  // recv , send
$result["data"] = array();

if (isset($_SESSION['pir_user_email'])) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_email='$pir_user_email'"))['member_no'];

    if ($type == 'send') {
        $sql = "SELECT * FROM `pir_messages` WHERE message_sent_id='$pir_user_no'";
        $rs = mysqli_query($dbconn, $sql);
        while ($row = mysqli_fetch_array($rs)) {
            if ($row['message_sent_del'] == 'Y')
                continue;

            $content['message_no'] = $row['message_no'];
            $recevier_id = $row['message_recv_id'];
            $content['message_target_no'] = $recevier_id;
            $content['message_target_nick'] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$recevier_id'"))['member_nickname'];

            $content['message_subject'] = $row['message_subject'];
            $content['message_body'] = $row['message_body'];
            $content['message_registered'] = $row['message_registered'];
            array_push($result['data'], $content);
        }
    } else {
        $sql = "SELECT * FROM `pir_messages` WHERE message_recv_id='$pir_user_no'";
        $rs = mysqli_query($dbconn, $sql);
        while ($row = mysqli_fetch_array($rs)) {
            if ($row['message_recv_del'] == 'Y')
                continue;

            $content['message_no'] = $row['message_no'];
            $sender_id = $row['message_sent_id'];
            $content['message_target_no'] = $sender_id;
            $content['message_target_nick'] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$sender_id'"))['member_nickname'];

            $content['message_subject'] = $row['message_subject'];
            $content['message_body'] = $row['message_body'];
            $content['message_registered'] = $row['message_registered'];
            array_push($result['data'], $content);
        }
    }
} else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
?>