<?php
if(!isset($_SESSION))
{
    session_start();
}
echo $_SESSION['pir_user_email'];
exit;
?>