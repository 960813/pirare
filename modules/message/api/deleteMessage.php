<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
if (isset($_SESSION['pir_user_email'])) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn,"SELECT member_no FROM `pir_members` WHERE member_email='$pir_user_email'"))[0];

    $type = $_GET['type'];
    $message_no = $_GET['no'];

    
    switch($type){
        case "send":
            $message_sender_no = mysqli_fetch_array(mysqli_query($dbconn,"SELECT message_sent_id FROM `pir_messages` WHERE message_no='$message_no'"))[0];
            if($pir_user_no==$message_sender_no){
                $result['success'] = true;
                $rs = mysqli_query($dbconn,"UPDATE `pir_messages` SET message_sent_del='Y' WHERE message_no='$message_no'");
                if($rs)
                    $result['success'] = true;
                else
                    $result['error'] = '삭제에 실패하였습니다.';
            }else
                $result['error'] = '본인이 보낸 쪽지만 삭제할 수 있습니다.';
            break;
        case "recv":
            $message_receiver_no = mysqli_fetch_array(mysqli_query($dbconn,"SELECT message_recv_id FROM `pir_messages` WHERE message_no='$message_no'"))[0];
            if($pir_user_no==$message_receiver_no){
                $result['success'] = true;
                $rs = mysqli_query($dbconn,"UPDATE `pir_messages` SET message_recv_del='Y' WHERE message_no='$message_no'");
                if($rs)
                    $result['success'] = true;
                else
                    $result['error'] = '삭제에 실패하였습니다.';
            }else
                $result['error'] = '본인이 받은 쪽지만 삭제할 수 있습니다.';
            break;
        case "all":
            $result['error'] = '개발중인 기능입니다.';
            break;
    }


}else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
?>