<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR . '../../_configure/dbconn.php');
?>
<?php
$id = $_GET['id'];
$imgData = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `pir_imgs` WHERE img_id='$id'"));


$img_absolute_path = '/usr/share/nginx/html/pirare/upload/';
//이미지 경로($img_path) , 이미지 이름($img_name)
$img_path = $imgData['img_path'];
$img_name_tmp = explode('upload/',$img_path)[1];
$img_name = str_replace('-image','',explode('_',$img_name_tmp)[1]);
/*
 *  ex)   $filename = "image1.png";
 *        $file =  $_SERVER['DOCUMENT_ROOT'] . "/images/" .$filename;
 */
$local_img_path = $img_absolute_path.$img_name_tmp;

if (is_file($local_img_path)) {

    if (preg_match("MSIE", $_SERVER['HTTP_USER_AGENT'])) {
        header("Content-type: application/octet-stream");
        header("Content-Length: ".filesize("$local_img_path"));
        header("Content-Disposition: attachment; filename=$img_name"); // 다운로드되는 파일명 (실제 파일명과 별개로 지정 가능)
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        header("Expires: 0");
    }
    else {
        header("Content-type: file/unknown");
        header("Content-Length: ".filesize("$local_img_path"));
        header("Content-Disposition: attachment; filename=$img_name"); // 다운로드되는 파일명 (실제 파일명과 별개로 지정 가능)
        header("Content-Description: PHP3 Generated Data");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    $fp = fopen($local_img_path, "rb");
    fpassthru($fp);
    fclose($fp);
}
else {
    echo "해당 파일이 없습니다.";
}
?>

