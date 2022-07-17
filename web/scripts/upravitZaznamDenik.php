<?php
session_start();
include_once 'dtb.php';

$idUkolu=$_POST['ukolid'];
$idZaznamu=$_POST['zaznamid'];

if(isset($_POST['sumbitUprava']))
{
	$zaznamText=$_POST['textZaznamu'];
	$sql = "UPDATE ukolykomentare SET textZaznamu=? WHERE id='$idZaznamu';";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/kalendar?ukol".$idUkolu);
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$zaznamText);	//urceni parametru, ktere chceme updatovat
		mysqli_stmt_execute($stmt);	//provedeni dotazu
		header("Location: ../pages/kalendar?ukol".$idUkolu);
		exit();
	}
}
?>
