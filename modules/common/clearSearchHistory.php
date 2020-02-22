<?php
$rs = setcookie("recentSearch", "", time() - 3600, '/'); //만료시간을 3600초 전으로 셋팅하여 확실히 제거
$result['success'] = $rs;
echo json_encode($result);
?>