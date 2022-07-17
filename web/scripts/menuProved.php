<?php
session_start();
include_once 'dtb.php';

$id=$_POST['idUzivatele'];
$ban = 1;
$unban =0;

if(isset($_POST['zabanovatSubmit'])){
    $sql = "UPDATE uzivatele SET ban=? WHERE id = $id;";
    $stmt = mysqli_stmt_init($pripojeni);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/menu?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s", $ban);
      mysqli_stmt_execute($stmt);
      header("Location: ../pages/menu?ban==uspesny");
      exit();
    }
}
else if(isset($_POST['unbanovatSubmit'])){
    $sql = "UPDATE uzivatele SET ban=? WHERE id = $id;";
    $stmt = mysqli_stmt_init($pripojeni);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/menu?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s", $unban);
      mysqli_stmt_execute($stmt);
      header("Location: ../pages/menu?unb==uspesny");
      exit();
    }
}
else if(isset($_POST['smazatSubmit'])){
    $sql = "DELETE FROM uzivatele WHERE id = ?;";
    $stmt = mysqli_stmt_init($pripojeni);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/menu?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s", $id);
      mysqli_stmt_execute($stmt);
      header("Location: ../pages/menu?smz==uspesny");
      exit();
    }
}
?>
