<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$id = $_GET['id'];

$result['success'] = false;

$imgData = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_imgs` WHERE img_id='$id'"));

//1. 작성자 이메일($img_owner_email)
$img_owner_no = $imgData['img_owner'];

//2. 작성자 닉네임($img_owner_nick)
$memberData = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE member_no='$img_owner_no  '"));
$img_owner_email = $memberData['member_email'];
$img_owner_nick = $memberData['member_nickname'];

//3. 이미지 경로($img_path)
$img_path = $imgData['img_path'];
//4. 이미지 메시지($img_msg)
$img_msg = $imgData['img_msg'];
//5. 이미지 등록 날짜($img_registered)
$img_registered = $imgData['img_registered'];

$img_id = $imgData['img_id'];
//6. 태그 아이디/이름($img_tag_id/$img_tag_name)
$img_tag_id = Array();
$img_tag_name = Array();
$tagRelation = mysqli_query($dbconn, "SELECT * FROM `pir_imgTags` WHERE imgTags_img_id='$img_id'");
while ($row = mysqli_fetch_array($tagRelation)) {
    $tid = $row['imgTags_tag_id'];
    $tagData = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_tags` WHERE tag_id='$tid'"));

    array_push($img_tag_id, $tid);
    array_push($img_tag_name, $tagData['tag_txt']);
}

//6. 번들 아이디/이름($img_bundle_id/$img_bundle_txt)

$img_bundle_id = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_bundleImgs` WHERE bundleImg_img_id='$img_id'"))['bundleImg_bundle_id'];
$img_bundle_txt = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_bundles` WHERE bundle_id='$img_bundle_id'"))['bundle_txt'];


$result["img_owner_no"] = $img_owner_no;
$result["img_owner_email"] = $img_owner_email;
$result["img_owner_nick"] = $img_owner_nick;
$result["img_path"] = "https://pirare.jupiterflow.com/upload/".$img_path;
$result["img_msg"] = $img_msg;
$result["img_registered"] = $img_registered;
$result["img_tag_id"] = $img_tag_id;
$result["img_tag_name"] = $img_tag_name;

$result["img_bundle_id"] = $img_bundle_id;
$result["img_bundle_txt"] = $img_bundle_txt;


$result["success"] = true;


echo json_encode($result);
?>