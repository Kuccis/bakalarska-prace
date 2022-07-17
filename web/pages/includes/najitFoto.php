<?php
$sessionid=$_SESSION['idUzivatele'];
$filename="../photos/profile/profile".$sessionid."*";
$fileinfo=glob($filename);
$fileext=explode(".",$fileinfo[0]);
?>
