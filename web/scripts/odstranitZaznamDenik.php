<?php
	session_start();
	include_once 'dtb.php';
	$idZaznamu=$_POST['zaznamid'];
  $idUkolu=$_POST['idUkolu'];

	if(isset($_POST['odstranitZaznam'])){
	 $sql = "DELETE FROM ukolykomentare WHERE id=?;";
	 $stmt = mysqli_stmt_init($pripojeni);

		 if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../pages/kalendar?error=sqlerror");
			exit();
		 }else{
			mysqli_stmt_bind_param($stmt,"s",$idZaznamu);
			mysqli_stmt_execute($stmt);
			header("Location: ../pages/kalendar?ukol".$idUkolu);
			exit();
		 }
	}
?>
