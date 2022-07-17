<?php
session_start();
include_once 'dtb.php';

$nazevUkolu=$_POST['nazevUkolu'];
$odkdy=$_POST['odkdy'];
$osfir=$_POST['osfir'];
$dokdy=$_POST['dokdy'];
$zamestnanec=$_POST['zamestnanec'];
$text=$_POST['textUlohy'];

$mesto=$_POST['mesto'];
$ulice=$_POST['ulice'];
$psc=$_POST['psc'];
$cp=$_POST['cp'];

$idUziv=$_SESSION['idUzivatele'];
$datum = date("Y-m-d");

if(isset($_POST['submitUloha'])){
      if(empty($nazevUkolu)){
        header("Location: ../pages/novyukol?nazev==nevyplnen");
        exit();
      }
      else if(empty($osfir)){
        header("Location: ../pages/novyukol?osfir==nevyplneno");
        exit();   
      }
      else if(empty($mesto)){
        header("Location: ../pages/novyukol?mesto==nevyplneno");
        exit();   
      }
      else if(empty($ulice)){
        header("Location: ../pages/novyukol?ulice==nevyplneno");
        exit();     
      }
      else if(empty($psc)){
        header("Location: ../pages/novyukol?psc==nevyplneno");
        exit();     
      }
      else if(empty($cp)){
        header("Location: ../pages/novyukol?cp==nevyplneno");
        exit();     
      }
      else if(empty($odkdy)){
        header("Location: ../pages/novyukol?odkdy==nevyplneno");
        exit();  
      }
      else if(empty($dokdy)){
        header("Location: ../pages/novyukol?dokdy==nevyplneno");
        exit();   
      }
      else if(empty($zamestnanec)){
        header("Location: ../pages/novyukol?zamestnanec==nevyplnen");
        exit();   
      }
      
      else
      {
          $sql="INSERT INTO ukoly (nazev,osfir,psc,mesto,ulice,cp,textUlohy,odkdy,dokdy,datum,zadal_id,zadany_monter_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    	  $stmt = mysqli_stmt_init($pripojeni);
    	  if(!mysqli_stmt_prepare($stmt,$sql)){
    			header("Location: ../index?error=sqlerror");
    			exit();
    	  }
    	  else{
    		mysqli_stmt_bind_param($stmt, "ssssssssssss", $nazevUkolu,$osfir, $psc, $mesto, $ulice, $cp, $text,$odkdy,$dokdy,$datum,$idUziv,$zamestnanec);
    		mysqli_stmt_execute($stmt);
            $sqlid="SELECT * FROM ukoly ORDER BY id DESC LIMIT 1";
            $vysid = mysqli_query($pripojeni,$sqlid);
            $idnew = mysqli_fetch_assoc($vysid);
    		header("Location: ../pages/kalendar?ukol".$idnew['id']);
    		exit();
    	  }
      }
      
	}
?>
