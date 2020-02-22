<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
session_start();
if (isset($_POST)) {
    $type = $_POST['type'];
    $txt = $_POST['txt'];

    $cnt = -1;
    if ($type == 'email') {
        $cnt = mysqli_num_rows(mysqli_query($dbconn,"SELECT * FROM `pir_members` WHERE member_email='$txt'"));
        if($cnt==0)
            $result['success'] = true;
    } else if ($type == 'nick') {
        $cnt = mysqli_num_rows(mysqli_query($dbconn,"SELECT * FROM `pir_members` WHERE member_nickname='$txt'"));
        if($cnt==0)
            $result['success'] = true;
    }
}else
    $result['error'] = '정상적인 요청이 아닙니다.';
echo json_encode($result);
?>
