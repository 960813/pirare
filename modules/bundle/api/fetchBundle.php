<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$no = $_GET["no"];
$query = $_GET['query'];
$result["data"] = array();

$bundleid = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM `pir_bundles` WHERE bundle_txt='$query'"))['bundle_id'];

$rs = mysqli_query($dbconn,"SELECT * FROM `pir_bundleImgs` WHERE bundleImg_bundle_id='$bundleid'");
while ($row = mysqli_fetch_array($rs)) {
    $imgid = $row['bundleImg_img_id'];
    $imgData = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM `pir_imgs` WHERE img_id='$imgid' order by img_id desc LIMIT ". $no .", 20"));

    $content["img_id"] = $imgData['img_id'];
    $content["img_path"] = "https://pirare.jupiterflow.com/upload/".$imgData['img_path'];
    $content["img_thumb_path"] = "https://pirare.jupiterflow.com/upload/".$imgData['img_thumb_path'];
    $content["img_msg"] = $imgData['img_msg'];

    array_push($result["data"], $content);
}
//print_r(json_encode($result));
echo json_encode($result);
//return json_encode($result);
?>