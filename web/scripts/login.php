<?php

if(isset($_POST['login'])){

	require 'dtb.php';

	$promMail=$_POST['email'];
	$promHeslo=$_POST['heslo1'];

	if(empty($promMail) || empty($promHeslo)){
		header("Location: ../index?error=nevyplnenepole");
		exit();
	}
	else{
		$sql = "SELECT * FROM uzivatele WHERE email=?;";
		$stmt = mysqli_stmt_init($pripojeni);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../index?error=sqlerror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt,"s", $promMail);
			mysqli_stmt_execute($stmt);
			$vys = mysqli_stmt_get_result($stmt);

			if($row = mysqli_fetch_assoc($vys)){
				$kontrolaHesla = password_verify($promHeslo,$row['heslo']);
				if($kontrolaHesla == false){
					header("Location: ../index?error=nespravneheslo");
					exit();
				}
				else if($kontrolaHesla == true){
					session_start();
					$_SESSION['idUzivatele'] = $row['id'];		// SESSION[jmeno]
					$_SESSION['jmenoUzivatele'] = $row['jmeno'];
          $_SESSION['prijmeniUzivatele'] = $row['prijmeni'];
					$_SESSION['emailUzivatele'] = $row['email'];
					$_SESSION['poziceUzivatele'] = $row['pozice'];
					$_SESSION['statusUzivatele'] = $row['profilovka'];
					$_SESSION['adminStav']=$row['admin'];
					$_SESSION['stavBan']=$row['ban'];
					$_SESSION['whitelist']=$row['whitelist'];
					header("Location: ../pages/uvod?login=uspesny");
					exit();
				}
				else {
					header("Location: ../index?error=nespravneheslo");
					exit();
				}
			}
			else{
				header("Location: ../index?error=ucetneexistuje");
				exit();
			}
		}
	}
}
else {
	header("Location: ../index");
	exit();
}
