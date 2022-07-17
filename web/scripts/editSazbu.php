<?php
session_start();
include_once 'dtb.php';

$monter=$_POST['monter'];
$skladnik=$_POST['skladnik'];
$sef=$_POST['sef'];

if(isset($_POST['submitSazba'])){
  if(empty($monter)){
    header("Location: ../pages/sazby?nevyplnen==monter");
    exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
  }
  else if(empty($skladnik)){
    header("Location: ../pages/sazby?nevyplnen==skladnik");
    exit();
  }
  else if(empty($sef)){
    header("Location: ../pages/sazby?nevyplnen==sef");
    exit();
  }
  else {
    $sql = "UPDATE nastaveniMenu SET cena=? WHERE nazev = 'Montér';";
    $stmt = mysqli_stmt_init($pripojeni);
    
    $sqla = "UPDATE nastaveniMenu SET cena=? WHERE nazev = 'Skladník';";
    $stmta = mysqli_stmt_init($pripojeni);
    
    $sqlb = "UPDATE nastaveniMenu SET cena=? WHERE nazev = 'Šéf';";
    $stmtb = mysqli_stmt_init($pripojeni);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/sazby?error=sqlerror");
      exit();
    }
    else if(!mysqli_stmt_prepare($stmta,$sqla)){
      header("Location: ../pages/sazby?error=sqlerror");
      exit();
    }
    else if(!mysqli_stmt_prepare($stmtb,$sqlb)){
      header("Location: ../pages/sazby?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s",$monter);
      mysqli_stmt_execute($stmt);
      
      mysqli_stmt_bind_param($stmta,"s",$skladnik);
      mysqli_stmt_execute($stmta);
      
      mysqli_stmt_bind_param($stmtb,"s",$sef);
      mysqli_stmt_execute($stmtb);
      header("Location: ../pages/sazby?editace==uspesna");
      exit();
    }
   }
}
?>
