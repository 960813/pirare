<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../_configure/dbconn.php');
?>
<?php
$result['success'] = false;
if(isset($_SESSION['pir_user_email'])) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $body = $_POST['body'];
    $category = $_POST['category'];




    $pir_user_nick = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_email='$pir_user_email'"))['member_nickname'];

    $to = 'pirare@jupiterflow.com';
    $subject = '[' . $category . ']' . $pir_user_nick;
    $message = $body;
    $headers = 'From: ' . $pir_user_email . "\r\n" .
        'Reply-To: ' . $pir_user_email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers))
        $result['success'] = true;
}else
    $result['error'] = '정상적인 요청이 아닙니다.';

echo json_encode($result);
exit;
?>
