<?php
session_start();
include_once 'dtb.php';

$idUziv=$_SESSION['idUzivatele'];
$idUkol=$_POST['ukolid'];
$zapis = $_POST['textZaznamu'];
$datum = date("Y-m-d");

if(isset($_POST['submitZaznam'])){
	  $sql="INSERT INTO ukolykomentare (id_uzivatele,id_ukolu,textZaznamu,datumZapisu) VALUES (?,?,?,?)";
	  $stmt = mysqli_stmt_init($pripojeni);
	  if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../pages/index?error=sqlerror");
			exit();
	  }
    else if(empty($zapis))
    {
      header("Location: ../pages/kalendar?ukol".$idUkol);
  		exit();
    }
	  else{
		mysqli_stmt_bind_param($stmt, "ssss",$idUziv, $idUkol,$zapis,$datum);
		mysqli_stmt_execute($stmt);
		header("Location: ../pages/kalendar?ukol".$idUkol);
		exit();
	  }
	}
?>
