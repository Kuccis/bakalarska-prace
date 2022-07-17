<?php
session_start();
include_once 'dtb.php';

if(isset($_POST['submitUloha'])){
    
  $idUkoluHidden=$_POST['idUkoluHidden'];
  $nazevUkolu=$_POST['nazevUkolu'];
  $osfir=$_POST['osfir'];
  $mesto=$_POST['mesto'];
  $ulice=$_POST['ulice'];
  $psc=$_POST['psc'];
  $cp=$_POST['cp'];
    
  $odkdy=$_POST['odkdy'];
  $dokdy=$_POST['dokdy'];
  $zamestnanec=$_POST['zamestnanec'];
  $text=$_POST['textUlohy'];
  $idUziv=$_SESSION['idUzivatele'];
  $datum = date("Y-m-d");    
    
  if(empty($nazevUkolu)){
    header("Location: ../pages/editukol?nazevPrazdny=ukol".$idUkoluHidden);
    exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
  }
  else if(empty($osfir)){
        header("Location: ../pages/novyukol?osfir==nevyplneno");
        exit();   
  }
  else if(empty($mesto)){
    header("Location: ../pages/editukol?mesto==nevyplneno");
    exit();   
  }
  else if(empty($ulice)){
    header("Location: ../pages/editukol?ulice==nevyplneno");
    exit();     
  }
  else if(empty($psc)){
    header("Location: ../pages/editukol?psc==nevyplneno");
    exit();     
  }
  else if(empty($cp)){
    header("Location: ../pages/editukol?cp==nevyplneno");
    exit();     
  }
  else if(empty($odkdy)){
    header("Location: ../pages/editukol?odkdyPrazdny=ukol".$idUkoluHidden);
    exit();
  }
  else if(empty($dokdy)){
    header("Location: ../pages/editukol?dokdyPrazdny=ukol".$idUkoluHidden);
    exit();
  }
  else if(empty($zamestnanec)){
    header("Location: ../pages/editukol?zamestnanecPrazdny=ukol".$idUkoluHidden);
    exit();
  }
  else {
    $sql = "UPDATE ukoly SET nazev=?,osfir=?,mesto=?,ulice=?,psc=?,cp=?,textUlohy=?,odkdy=?,dokdy=?,zadany_monter_id=? WHERE id = $idUkoluHidden;";
    $stmt = mysqli_stmt_init($pripojeni);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/kalendar?editace==neuspesna");
      exit();
    }else{
      mysqli_stmt_bind_param($stmt,"ssssssssss",$nazevUkolu,$osfir,$mesto,$ulice,$psc,$cp,$text,$odkdy,$dokdy,$zamestnanec);
      mysqli_stmt_execute($stmt);
      header("Location: ../pages/kalendar?editace==uspesna");
      exit();
    }
  }
}
?>
