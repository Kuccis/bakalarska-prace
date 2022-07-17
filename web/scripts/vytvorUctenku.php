<?php
session_start();
include_once 'dtb.php';

if(isset($_POST['vytvorUctenku'])){
      $idUkolu=$_POST['idUkolu'];
      $pocetHodin=$_POST['pocetHodin'];
      $datum = date("Y-m-d");
      $cena=$_POST['cenaUkolu'];
      $hodinovaSazba=$_POST['hodSaz'];
      $idUziv=$_SESSION['idUzivatele'];
      
      if(empty($idUkolu)){
        header("Location: ../pages/ucet?error=sqlerror");
        exit();
      }
      else if(empty($hodinovaSazba))
      {
        header("Location: ../pages/ucet?ukol".$idUkolu."#sazba==error");
        exit();   
      }
      else if(empty($pocetHodin))
      {
        header("Location: ../pages/ucet?ukol".$idUkolu."#cas==nevyplnen");
        exit();   
      }
      else if(empty($cena)){
        header("Location: ../pages/ucet?ukol".$idUkolu."#cena==nevyplnena");
        exit();   
      }
      else
      {
          $sql="INSERT INTO uctenky (idUkolu,idVytvoril,cena,odpracHodin,datum,hodSazba) VALUES (?,?,?,?,?,?)";
    	  $stmt = mysqli_stmt_init($pripojeni);
    	  if(!mysqli_stmt_prepare($stmt,$sql)){
    			header("Location: ../index?error=sqlerror");
    			exit();
    	  }
    	  else{
    		mysqli_stmt_bind_param($stmt, "ssssss", $idUkolu,$idUziv,$cena,$pocetHodin,$datum,$hodinovaSazba);
    		mysqli_stmt_execute($stmt);
    		header("Location: ../pages/ucet?ukol".$idUkolu);
    		exit();
    	  }
      }
      
	}
?>
