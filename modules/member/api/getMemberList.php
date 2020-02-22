<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
$result['data'] = array();
session_start();
if (isset($_SESSION['pir_user_email'])) {
//    $rs = mysqli_query($dbconn, "SELECT * FROM `pir_members` LIMIT ".$no.", 10");
    $rs = mysqli_query($dbconn, "SELECT * FROM `pir_members`");
    while($row = mysqli_fetch_array($rs)){

        $content["member_no"] = $row['member_no'];
        $content["member_nickname"] = $row['member_nickname'];

        $result['success'] = true;
        array_push($result["data"], $content);
    }
} else
    $result['error'] = '정상적인 요청이 아닙니다.';
echo json_encode($result);
?>
