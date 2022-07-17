<?php
session_start();
include_once 'dtb.php';

$idUzivatele=$_POST['idUzivatele'];
$mailHodnota=$_POST['mailHodnota'];

if(isset($_POST['submitMail']))
{
	$sqle = "SELECT * FROM uzivatele WHERE email='$mailHodnota';";
	$stmte = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmte,$sqle)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/nastaveni?error=sqlerror");
		exit();
	}
	else if(empty($mailHodnota)){
	    header("Location: ../pages/nastaveni?email==nevyplnen");
		exit();
	}
	else{
	    mysqli_stmt_execute($stmte);
	    mysqli_stmt_store_result($stmte);
        $pocet = mysqli_stmt_num_rows($stmte);
        if($pocet > 0){
    		header("Location: ../pages/nastaveni?error==emailjezabrany");
    		exit();
        }
        else{
            $sql = "UPDATE uzivatele SET email=? WHERE id='$idUzivatele';";
	        $stmt = mysqli_stmt_init($pripojeni);
	        if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
        		header("Location: ../pages/nastaveni?error=sqlerror");
        		exit();
        	}
        	else{
                mysqli_stmt_bind_param($stmt,"s",$mailHodnota);	//urceni parametru, ktere chceme updatovat
        		mysqli_stmt_execute($stmt);	//provedeni dotazu
                header("Location: ../pages/nastaveni?zmenaMail==probehla");
        		exit();
        	}
        }
	}
}
?>
