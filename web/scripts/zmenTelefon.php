<?php
session_start();
include_once 'dtb.php';

$idUzivatele=$_POST['idUzivatele'];
$telefonHodnota=$_POST['novyTelefon'];
if(isset($_POST['zmenTelefon']))
{
    if(empty($telefonHodnota)){
        header("Location: ../pages/nastaveni?zmenaTelcis==nevyplnenePole");
    	exit();
    }
    else if(!is_numeric($telefonHodnota)){
        header("Location: ../pages/nastaveni?zmenaTelcis==spatnyVstup");
    	exit();
    }
    else if(strlen($telefonHodnota) != 9)
    {
        header("Location: ../pages/nastaveni?zmenaTelcis==problemDelka");
    	exit();
    }
    else{
        $sql = "UPDATE uzivatele SET telcis=? WHERE id='$idUzivatele';";
    	$stmt = mysqli_stmt_init($pripojeni);
    	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
    		header("Location: ../pages/nastaveni?error=sqlerror");
    		exit();
    	}else{
    		mysqli_stmt_bind_param($stmt,"s",$telefonHodnota);	//urceni parametru, ktere chceme updatovat
    		mysqli_stmt_execute($stmt);	//provedeni dotazu
            mysqli_stmt_store_result($stmt);
            header("Location: ../pages/nastaveni?zmenaTelcis==probehla");
    		exit();
    	}
    }
}
?>
