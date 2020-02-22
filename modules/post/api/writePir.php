<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
function createThumbnailImage($org_image, $upload_ext, $upload_path)
{
    switch ($upload_ext) {
        case 'jpeg':
        case 'jpg':
            $upload_image = imagecreatefromjpeg($org_image);
            break;
        case 'png':
            $upload_image = imagecreatefrompng($org_image);
            break;
        case 'gif':
//            $upload_image = imagecreatefromgif($org_image);
            return -1;
            break;
        default:
            $upload_image = imagecreatefromjpeg($org_image);
    }
    $org_width = imagesx($upload_image);
    $scale_width = 600;
    $org_height = imagesy($upload_image);

    $new_height = (($org_height * $scale_width) / $org_width);

    if ($scale_width > $org_width) {
        return -1;
    }


    $thumb_create = imagecreatetruecolor($scale_width, $new_height);


    imagecopyresized($thumb_create, $upload_image, 0, 0, 0, 0, $scale_width, $new_height, $org_width, $org_height);

    $thumb_quality = 90;
    switch ($upload_ext) {
        case 'jpg' || 'jpeg':
            imagejpeg($thumb_create, $upload_path, $thumb_quality);
            break;
        case 'png':
            imagepng($thumb_create, $upload_path);
            break;
        case 'gif':
            imagegif($thumb_create, $upload_path);
            break;
        default:
            imagejpeg($thumb_create, $upload_path, $thumb_quality);
    }


    return $upload_path;
}

?>
<?php
$path = '/usr/share/nginx/html/pirare/upload/';
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
$data['success'] = false;

if (isset($_SESSION['pir_user_email']) and isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES['pir_image']['name'];
    $size = $_FILES['pir_image']['size'];

    $msg = addslashes($_POST['msg']);
    $tag = array_values(array_filter(array_map('trim', explode(',', $_POST['tag']))));

    $bundle = $_POST['bundle'];

    $pir_user = $_SESSION['pir_user_email'];
    $pir_user_no = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_members` WHERE `member_email` = '$pir_user';"))['member_no'];

    list($txt, $ext) = explode(".", $name);
    $time = time();
    if (in_array(strtolower($ext), $valid_formats)) {
        $actual_image_name = $time . "_" . $txt . "-image." . $ext;
        $tmp = $_FILES['pir_image']['tmp_name'];

        if (move_uploaded_file($tmp, $path . $actual_image_name)) {
            // thumbnail_path
            $thumbnail_name = $time . "_" . $txt . "-thumbnail." . $ext;
            $thumbnail_path = $path . $thumbnail_name;
            $selector = createThumbnailImage($path . $actual_image_name, $ext, $thumbnail_path);
            switch ($selector) {
                case -1:
                    $thumbnail_name = $actual_image_name;
                    break;
            }
            $data['success'] = true;

//            $iurl = "https://pirare.jupiterflow.com/upload/" . $actual_image_name;
//            $turl = "https://pirare.jupiterflow.com/upload/" . $thumbnail_name;
            $iurl = $actual_image_name;
            $turl = $thumbnail_name;

            $imgid = -1;
            $tagid = -1;
            $bundleid = -1;
            if (mysqli_query($dbconn, "INSERT INTO pir_imgs(img_owner, img_path, img_thumb_path, img_msg) VALUES ('$pir_user_no','$iurl','$turl','$msg')")) {
                $imgid = mysqli_fetch_row(mysqli_query($dbconn, "SELECT LAST_INSERT_ID();"))[0];

                if (!empty($tag)) {
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
                        if (mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM pir_imgTags WHERE imgTags_img_id='$imgid' AND imgTags_tag_id='$tagid'")) < 1) {
                            if (!mysqli_query($dbconn, "INSERT INTO pir_imgTags(imgTags_img_id,imgTags_tag_id) VALUES ('$imgid','$tagid')")) {
                                $data['success'] = false;
                                $data['error'] = "pir_imgTags(" . $tagid . ") 등록 실패";
                            }
                        }
                    }
                }

                if (!empty($bundle)) {
                    $tagresult = mysqli_query($dbconn, "SELECT bundle_id FROM pir_bundles WHERE bundle_txt='$bundle'");
                    if (mysqli_num_rows($tagresult) > 0) {
                        $bundleid = mysqli_fetch_row($tagresult)[0];
                    } else {
                        if (mysqli_query($dbconn, "INSERT INTO pir_bundles(bundle_txt) VALUES ('$bundle')")) {
                            // 번들 등록 성공
                            $bundleid = mysqli_fetch_row(mysqli_query($dbconn, "SELECT LAST_INSERT_ID();"))[0];
                        } else {
                            // 번들 등록 실패
                        }
                    }
                    if (!mysqli_query($dbconn, "INSERT INTO pir_bundleImgs(bundleImg_bundle_id,bundleImg_img_id) VALUES ('$bundleid','$imgid')")) {
                        $data['success'] = false;
                        $data['error'] = "pir_imgTags 등록 실패";
                    }
                }


                $data['success'] = true;
                $data['url'] = $iurl;
                $data['thumbnail'] = $turl;
            } else {
                //이미지 등록 실패
            }
        } else {
            //이미지 저장 실패
            $data['success'] = false;
            $data['error'] = "error";
        }
    } else {
        $data['error'] = "Invalid file format..[$name / $txt / $ext]";
    }
} else
    $result['error'] = '정상적인 요청이 아닙니다.';
echo json_encode($data);
?>