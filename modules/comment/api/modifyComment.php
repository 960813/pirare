<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$data['success'] = false;
if (isset($_SESSION['pir_user_email']) and isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $imgid = $_POST['imgid'];
    $commentid = $_POST['commentid'];
    $msg = addslashes($_POST['msg']);
    $owner_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT comment_owner FROM `pir_comments` WHERE comment_id='$commentid'"))[0];
    $owner_email = mysqli_fetch_array(mysqli_query($dbconn, "SELECT member_email FROM `pir_members` WHERE member_no='$owner_no'"))[0];

    if ($owner_email != $_SESSION['pir_user_email']) {
        $result['error'] = '본인의 댓글만 수정할 수 있습니다.';
    } else {
        if (mysqli_query($dbconn, "UPDATE pir_comments SET comment_msg='$msg' WHERE comment_id='$commentid'")) {
            $data['success'] = true;
        } else {
            $data['error'] = '댓글 수정에 실패하였습니다.';
        }
    }
} else {
    $data['error'] = '정상적인 요청이 아닙니다.';
}
echo json_encode($data);
?>
