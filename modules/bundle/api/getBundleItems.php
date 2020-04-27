<?php
$HOME_DIR = str_replace(basename(__FILE__), '', realpath(__FILE__));
require_once($HOME_DIR.'../../_configure/dbconn.php');
?>
<?php
if(!isset($_SESSION))
{
    session_start();
}
$sql = "SELECT * FROM `pir_bundles`;";

$rs  = mysqli_query($dbconn, $sql);

$result["success"] = true;
$result["data"] = Array();
while($row=mysqli_fetch_array($rs)){
    $content["bundle_id"] = $row['bundle_id'];
    $content["bundle_txt"] = $row['bundle_txt'];

    array_push($result["data"],$content);
}
echo json_encode($result);
?>