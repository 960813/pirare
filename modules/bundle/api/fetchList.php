<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$no = $_GET["no"];
$result["data"] = array();

$sql = "SELECT * FROM `pir_bundles` order by bundle_id desc LIMIT " . $no . ", 20";

$rs = mysqli_query($dbconn, $sql);
while ($row = mysqli_fetch_array($rs)) {
    $bundleImg_bundle_id = $row['bundle_id'];
    $content["bundle_id"] = $bundleImg_bundle_id;
    $content["bundle_txt"] = $row['bundle_txt'];
    $content["bundle_owner"] = $row['bundle_owner'];
    $bundleImg_img_id = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_bundleImgs` WHERE bundleImg_bundle_id='$bundleImg_bundle_id' order by rand() limit 1"))['bundleImg_img_id'];
    $bundleRepImgThumbnailPath = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_imgs` WHERE img_id='$bundleImg_img_id'"))['img_thumb_path'];

    $content["bundle_thumb_path"] = "https://pirare.jupiterflow.com/upload/".$bundleRepImgThumbnailPath;

    if ($content["bundle_thumb_path"])
        array_push($result["data"], $content);
}
//print_r(json_encode($result));
echo json_encode($result);
//return json_encode($result);
?>