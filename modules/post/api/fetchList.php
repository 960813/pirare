<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$no = $_GET["no"];
$result["data"] = array();

$sortType = 'img_id desc';
if(isset($_SESSION['pir_user_email'])) {
    $pir_user_email = $_SESSION['pir_user_email'];
    $member_sort = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_email='$pir_user_email'"))['member_sort'];
    switch($member_sort){
        case 'desc':
            $sortType = 'img_id desc';
            break;
        case 'asc':
            $sortType = 'img_id asc';
            break;
        case 'rand':
            $sortType = 'rand()';
            break;
    }
}

$sql = "SELECT * FROM `pir_imgs` order by ".$sortType." LIMIT " . $no . ", 20";

$rs = mysqli_query($dbconn, $sql);
while ($row = mysqli_fetch_array($rs)) {
    $content["img_id"] = $row['img_id'];
    $content["img_path"] = "https://pirare.jupiterflow.com/upload/".$row['img_path'];
    $content["img_thumb_path"] = "https://pirare.jupiterflow.com/upload/".$row['img_thumb_path'];
    $content["img_msg"] = $row['img_msg'];

    array_push($result["data"], $content);
}
//print_r(json_encode($result));
echo json_encode($result);
//return json_encode($result);
?>