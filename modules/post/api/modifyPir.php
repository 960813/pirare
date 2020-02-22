<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$id = $_POST['id'];
$msg = addslashes($_POST['msg']);
$tag = array_unique(array_values(array_filter(array_map('trim', explode(',', $_POST['tag'])))));
$bundle = $_POST['bundle'];
$result['success'] = false;

$owner_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT img_owner FROM `pir_imgs` WHERE img_id='$id'"))[0];
$owner_email = mysqli_fetch_array(mysqli_query($dbconn, "SELECT member_email FROM `pir_members` WHERE member_no='$owner_no'"))[0];

// 권한 검증
if ($owner_email != $_SESSION['pir_user_email']) {
    $result['error'] = '본인의 게시글만 수정할 수 있습니다.';
} else {

    $rs = mysqli_query($dbconn, "UPDATE pir_imgs SET img_msg='$msg' WHERE img_id='$id';");

    $tagid = -1;
    if (!empty($tag)) {
        mysqli_query($dbconn, "DELETE FROM pir_imgTags WHERE imgTags_img_id='$id'");
        for ($i = 0; $i <= count($tag); $i++) {
            $tagtxt = $tag[$i];
            if (empty($tagtxt))
                continue;

            $tagresult = mysqli_query($dbconn, "SELECT tag_id FROM pir_tags WHERE tag_txt='$tagtxt'");
            if (mysqli_num_rows($tagresult) > 0) {
                $tagid = mysqli_fetch_row($tagresult)[0];
            } else {
                if (mysqli_query($dbconn, "INSERT INTO pir_tags(tag_txt) VALUES ('$tagtxt')")) {
                    // 태그 등록 성공
                    $tagid = mysqli_fetch_row(mysqli_query($dbconn, "SELECT LAST_INSERT_ID();"))[0];
                } else {
                    // 태그 등록 실패
                }
            }
            if (!mysqli_query($dbconn, "INSERT INTO pir_imgTags(imgTags_img_id,imgTags_tag_id) VALUES ('$id','$tagid')")) {
                $data['success'] = false;
                $data['error'] = "pir_imgTags(" . $tagid . ") 등록 실패";
            }
        }
    }

    $bundleid = -1;

    $bundle_tmp_id = mysqli_fetch_array(mysqli_query($dbconn,"SELECT bundleImg_bundle_id FROM `pir_bundleImgs` WHERE bundleImg_img_id='$id'"))[0];
    $bundle_tmp_lists = mysqli_num_rows(mysqli_query($dbconn,"SELECT bundleImg_bundle_id FROM `pir_bundleImgs` WHERE bundleImg_bundle_id='$bundle_tmp_id'"));
    if($bundle_tmp_lists==1)
        mysqli_query($dbconn, "DELETE FROM pir_bundles WHERE bundle_id='$bundle_tmp_id'");

    mysqli_query($dbconn, "DELETE FROM pir_bundleImgs WHERE bundleImg_img_id='$id'");
    if (!empty($bundle)) {
        $bundleResult = mysqli_query($dbconn, "SELECT bundle_id FROM pir_bundles WHERE bundle_txt='$bundle'");
        if (mysqli_num_rows($bundleResult) > 0) {
            $bundleid = mysqli_fetch_row($bundleResult)[0];
        } else {
            if (mysqli_query($dbconn, "INSERT INTO pir_bundles(bundle_txt) VALUES ('$bundle')")) {
                // 번들 등록 성공
                $bundleid = mysqli_fetch_row(mysqli_query($dbconn, "SELECT LAST_INSERT_ID();"))[0];
            } else {
                // 번들 등록 실패
            }
        }
        if (!mysqli_query($dbconn, "INSERT INTO pir_bundleImgs(bundleImg_bundle_id,bundleImg_img_id) VALUES ('$bundleid','$id')")) {
            $data['success'] = false;
            $data['error'] = "pir_bundleImgs(" . $bundleid . ") 등록 실패";
        }

    }
    $data['success'] = true;
}
echo json_encode($data);
exit;
?>