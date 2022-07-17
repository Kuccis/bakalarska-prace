<?php
	$pripojeni=mysqli_connect("localhost","kucera31","Kucera18","javosoftware");

	if(!$pripojeni){
        die("Připojení selhalo: ".mysqli_connect_error());
    }
?>
