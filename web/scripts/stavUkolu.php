<?php
session_start();
include_once 'dtb.php';

$idUkolu=$_POST['idUkoluHidden'];

if($_SESSION['poziceUzivatele'] == "Šéf" || $_SESSION['poziceUzivatele'] == "Administrátor"){
    if(isset($_POST['ukolHotov']))
    {
    	$text="hotove";
    	$sql = "UPDATE ukoly SET stav=? WHERE id='$idUkolu';";
    	$stmt = mysqli_stmt_init($pripojeni);
    	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}else{
    		mysqli_stmt_bind_param($stmt,"s",$text);	//urceni parametru, ktere chceme updatovat
    		mysqli_stmt_execute($stmt);	//provedeni dotazu
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}
    }
    else if(isset($_POST['ukolProbi'])){
        $text="probihajici";
    	$sql = "UPDATE ukoly SET stav=? WHERE id='$idUkolu';";
    	$stmt = mysqli_stmt_init($pripojeni);
    	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}else{
    		mysqli_stmt_bind_param($stmt,"s",$text);	//urceni parametru, ktere chceme updatovat
    		mysqli_stmt_execute($stmt);	//provedeni dotazu
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}
    }
    else if(isset($_POST['ukolNedoko'])){
        $text="nesplnene";
    	$sql = "UPDATE ukoly SET stav=? WHERE id='$idUkolu';";
    	$stmt = mysqli_stmt_init($pripojeni);
    	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}else{
    		mysqli_stmt_bind_param($stmt,"s",$text);	//urceni parametru, ktere chceme updatovat
    		mysqli_stmt_execute($stmt);	//provedeni dotazu
    		header("Location: ../pages/kalendar?ukol".$idUkolu);
    		exit();
    	}
    }
}
else
{
    header("Location: ../index?neopravnenyPristup");
    exit();
}
?>
