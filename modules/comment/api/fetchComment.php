<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
$result['data'] = array();
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $imgid = $_POST['imgid'];

    $rs = mysqli_query($dbconn, "SELECT * FROM `pir_imgComments` WHERE imgComments_img_id='$imgid'");
    while ($row = mysqli_fetch_array($rs)) {
        $commentid = $row['imgComments_comment_id'];
        $commentData = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_comments` WHERE comment_id='$commentid'"));

        $content["comment_id"] = $commentData['comment_id'];
        $ownerid = $commentData['comment_owner'];
        $content["comment_owner_id"] = $ownerid;
        $content["comment_owner_email"] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$ownerid';"))['member_email'];
        $content["comment_owner_nick"] = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$ownerid';"))['member_nickname'];
        $content["comment_msg"] = $commentData['comment_msg'];
        $content["comment_registered"] = $commentData['comment_registered'];
        $result['success'] = true;
        array_push($result["data"], $content);
    }
} else {
    $result['error'] = '정상적인 요청이 아닙니다.';
}
echo json_encode($result);
?>
