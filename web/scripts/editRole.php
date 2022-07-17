<?php
session_start();
include_once 'dtb.php';

$id=$_POST['idUzivatele'];
$pozice=$_POST['pozice'];;

if(isset($_POST['upravPozici'])){
  if($pozice == "nezadáno"){
      if($_SESSION['poziceUzivatele'] == "Šéf"){
          header("Location: ../pages/role?nevyplnena==role");
          exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
      }
      else{
          header("Location: ../pages/menu?nevyplnena==role");
          exit();
      }
  }
  else {
    $sql = "UPDATE uzivatele SET pozice=? WHERE id = $id;";
    $stmt = mysqli_stmt_init($pripojeni);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/role?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s",$pozice);
      mysqli_stmt_execute($stmt);
      if($_SESSION['poziceUzivatele'] == "Šéf"){
          header("Location: ../pages/role?editace==uspesna");
          exit();
      }
      else
      {
          header("Location: ../pages/menu?editace==uspesna");
          exit();
      }
    }
   }
}
?>
