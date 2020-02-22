<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR.'../../_configure/dbconn.php');
?>
<?php
$no = $_GET["no"];
$query = urldecode($_GET["query"]);
$result["data"] = array();


$tag_id = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM pir_tags WHERE tag_txt='$query'"))['tag_id'];
$result['test'] = $tag_id;

$rs = mysqli_query($dbconn,"SELECT * FROM pir_imgTags WHERE imgTags_tag_id='$tag_id'");
while($row=mysqli_fetch_array($rs)){
    $target_img_id = $row['imgTags_img_id'];
    $row = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM pir_imgs WHERE img_id='$target_img_id'"));

    $content["img_id"] = $row['img_id'];
    $content["img_path"] = "https://pirare.jupiterflow.com/upload/".$row['img_path'];
    $content["img_thumb_path"] = "https://pirare.jupiterflow.com/upload/".$row['img_thumb_path'];
    $content["img_msg"] = $row['img_msg'];

    array_push($result["data"],$content);
}
echo json_encode($result);
?>