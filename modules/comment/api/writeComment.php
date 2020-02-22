<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$data['success'] = false;
if (isset($_SESSION['pir_user_email']) and isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $imgid = $_POST['imgid'];
    $msg = addslashes($_POST['msg']);
    if(!empty($msg)) {
        $pir_user = $_SESSION['pir_user_email'];
        $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$pir_user';"))['member_no'];

        if (mysqli_query($dbconn, "INSERT INTO pir_comments(comment_owner, comment_msg) VALUES ('$pir_user_no','$msg')")) {
            $commentid = mysqli_fetch_row(mysqli_query($dbconn, "SELECT LAST_INSERT_ID();"))[0];
            if (!mysqli_query($dbconn, "INSERT INTO pir_imgComments(imgComments_img_id,imgComments_comment_id) VALUES ('$imgid','$commentid')")) {
                $data['success'] = false;
                $data['error'] = "pir_imgComments(" . $imgid . '/' . $commentid . ") 등록 실패";
            } else
                $data['success'] = true;
        } else {
            $data['error'] = '댓글 등록에 실패하였습니다.';
        }
    }else
        $data['error'] = '댓글 내용을 입력해주세요.';
}else{
    $data['error'] = '정상적인 요청이 아닙니다.';
}
echo json_encode($data);
?>
