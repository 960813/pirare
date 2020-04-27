<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
if(!isset($_SESSION))
{
    session_start();
}
$no = $_GET["no"];
$result['success'] = false;

$owner_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT img_owner FROM `pir_imgs` WHERE img_id='$no'"))[0];
$owner_email = mysqli_fetch_array(mysqli_query($dbconn, "SELECT member_email FROM `pir_members` WHERE member_no='$owner_no'"))[0];

if ($owner_email != $_SESSION['pir_user_email']) {
    $result['error'] = '본인의 게시글만 삭제할 수 있습니다.';
} else {
    $rs_bundleid = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_bundleImgs` WHERE bundleImg_img_id='$no'"))['bundleImg_bundle_id'];
    $rs_bundleData = mysqli_query($dbconn, "SELECT * FROM `pir_bundleImgs` WHERE bundleImg_bundle_id='$rs_bundleid'");
    if (mysqli_num_rows($rs_bundleData) == 1) {
        $result['test'] = mysqli_query($dbconn, "DELETE FROM `pir_bundles` WHERE bundle_id='$rs_bundleid'");
    }
    $rs_img_data = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_imgs` WHERE img_id='$no'"));

    $path = '/usr/share/nginx/html/pirare/upload/';
    $rs_img_path = $path.$rs_img_data['img_path'];
    $rs_img_thumb_path = $path.$rs_img_data['img_thumb_path'];

    if(is_file($rs_img_path))
        unlink($rs_img_path);
    if(is_file($rs_img_thumb_path))
        unlink($rs_img_thumb_path);

    if (mysqli_query($dbconn, "DELETE FROM `pir_imgs` WHERE img_id='$no'"))
        $result['success'] = true;
    else
        $result['error'] = '삭제 실패';
}
echo json_encode($result);
?>