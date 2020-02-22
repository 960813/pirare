<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR.'../../_configure/dbconn.php');
?>
<?php
$no = $_GET["no"];
$result["data"] = array();

$sql1 = "SELECT * FROM `pir_contents` LIMIT ".$no.", 4";
$rs1  = mysqli_query($dbconn, $sql1);
while($row1=mysqli_fetch_array($rs1)){
    $content["content_id"] = $row1['content_id'];
    $content["content_msg"] = $row1['content_msg'];
    $content["content_img"] = array();

    $sql2 = "SELECT * FROM `pir_imgs` WHERE img_target=".$content["content_id"];
    $rs2 = mysqli_query($dbconn, $sql2);
    while($row2=mysqli_fetch_array($rs2)){
        $img["img_id"] = $row2['img_id'];
        $img["img_path"] = $row2['img_path'];
        array_push($content["content_img"],$img);
    }

    array_push($result["data"],$content);
}
echo json_encode($result);
?>