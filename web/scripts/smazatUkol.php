<?php
	session_start();
	include_once 'dtb.php';
	
	$idUkolu=$_POST['idUkoluHidden'];

	if(isset($_POST['smazatUkol'])){
	 //mazani ukolu
	 $sql = "DELETE FROM ukoly WHERE id=?;";
	 $stmt = mysqli_stmt_init($pripojeni);
	 
	 if(!mysqli_stmt_prepare($stmt,$sql)){
		header("Location: ../pages/kalendar?error=sqlerror");
		exit();
	 }
     else{
		//provedeni mazani ukolu
		mysqli_stmt_bind_param($stmt,"s",$idUkolu);
		mysqli_stmt_execute($stmt);
		
		//provedeni mazani komentaru u ukolu\
		$sqli = "DELETE FROM ukolykomentare WHERE id_ukolu=$idUkolu;";
		$vysi = mysqli_query($pripojeni,$sqli);
		header("Location: ../pages/kalendar?smazaniUkolu=uspesne");
	 	exit();
	 }
	}
	//-------------------------------------------------------------------------
	else if(isset($_POST['smazatUkolMenu'])){
	 //mazani ukolu z admin menu
	 $sql = "DELETE FROM ukoly WHERE id=?;";
	 $stmt = mysqli_stmt_init($pripojeni);
	 
	 if(!mysqli_stmt_prepare($stmt,$sql)){
		header("Location: ../pages/menu?error=sqlerror");
		exit();
	 }
     else{
		//provedeni mazani ukolu
		mysqli_stmt_bind_param($stmt,"s",$idUkolu);
		mysqli_stmt_execute($stmt);
		
		//provedeni mazani komentaru u ukolu\
		$sqli = "DELETE FROM ukolykomentare WHERE id_ukolu=$idUkolu;";
		$vysi = mysqli_query($pripojeni,$sqli);
		header("Location: ../pages/menu?smazaniUkolu=uspesne");
	 	exit();
	 }
	}
?>
