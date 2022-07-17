<?php
session_start();
include_once 'dtb.php';

if(isset($_POST['schvalitSubmit']))
{
    $stav=3;
	$idObjednavky=$_POST['idObjednavkyHidden'];
	$idUkolu=$_POST['idUkoluHidden'];
	$sql = "UPDATE objednavkySklad SET stav=? WHERE id='$idObjednavky';";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/objednavky?error=sqlerror");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$stav);	//urceni parametru, ktere chceme updatovat
		mysqli_stmt_execute($stmt);	//provedeni dotazu
		
		$sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky=$idObjednavky;";
        $vysVec = mysqli_query($pripojeni,$sqlVec);
        while($rowVec = mysqli_fetch_assoc($vysVec)){
            $idVeci=$rowVec['idVeci'];
            $sqlSklad = "SELECT * FROM `skladiste` WHERE id=$idVeci;";
            $vysSklad = mysqli_query($pripojeni,$sqlSklad);
            $rowSklad = mysqli_fetch_assoc($vysSklad);
            $pom = $rowSklad['pocet'];
            $pom=$pom-$rowVec['pocetVeci'];
            $sqla = "UPDATE skladiste SET pocet=? WHERE id='$idVeci';";
    	    if(!mysqli_stmt_prepare($stmt,$sqla)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
        		header("Location: ../pages/objednavky?error=sqlerror");
        		exit();
        	}
        	else
        	{
        	    mysqli_stmt_bind_param($stmt,"s",$pom);	//urceni parametru, ktere chceme updatovat
		        mysqli_stmt_execute($stmt);	//provedeni dotazu
        	}
        }
    	
		header("Location: ../pages/objednavky?ukol".$idObjednavky);
		exit();
	}
}
else if(isset($_POST['zamitnoutSubmit']))
{
    $stav=2;
	$idObjednavky=$_POST['idObjednavkyHidden'];
	$sql = "UPDATE objednavkySklad SET stav=? WHERE id='$idObjednavky';";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/objednavky?error=sqlerror");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$stav);	//urceni parametru, ktere chceme updatovat
		mysqli_stmt_execute($stmt);	//provedeni dotazu
		header("Location: ../pages/objednavky?ukol".$idObjednavky);
		exit();
	}
}
else if(isset($_POST['vydatVeci']))
{
    $stav=4;
    $idObjednavky=$_POST['idObjednavkyHidden'];
	$sql = "UPDATE objednavkySklad SET stav=? WHERE id='$idObjednavky';";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/objednavky?error=sqlerror");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$stav);	//urceni parametru, ktere chceme updatovat
		mysqli_stmt_execute($stmt);	//provedeni dotazu
		if($_SESSION['poziceUzivatele'] != "Administrátor"){
    	   header("Location: ../pages/objednavky");
    	   exit();
		}
		else{
		   header("Location: ../pages/menu?objednavky");
    	   exit(); 
		}
	}
}
else if(isset($_POST['vratitSubmit']))
{
    $stav=5;
    $idObjednavky=$_POST['idObjednavkyHidden'];
	$idUkolu=$_POST['idUkoluHidden'];
	$sql = "UPDATE objednavkySklad SET stav=? WHERE id='$idObjednavky';";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
		header("Location: ../pages/objednavky?error=sqlerror");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$stav);	//urceni parametru, ktere chceme updatovat
		mysqli_stmt_execute($stmt);	//provedeni dotazu
		
		$sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky=$idObjednavky;";
        $vysVec = mysqli_query($pripojeni,$sqlVec);
        while($rowVec = mysqli_fetch_assoc($vysVec)){
            $idVeci=$rowVec['idVeci'];
            $sqlSklad = "SELECT * FROM `skladiste` WHERE id=$idVeci;";
            $vysSklad = mysqli_query($pripojeni,$sqlSklad);
            $rowSklad = mysqli_fetch_assoc($vysSklad);
            $pom = $rowSklad['pocet'];
            $pom=$pom+$rowVec['pocetVeci'];
            $sqla = "UPDATE skladiste SET pocet=? WHERE id='$idVeci';";
    	    if(!mysqli_stmt_prepare($stmt,$sqla)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
        		header("Location: ../pages/objednavky?error=sqlerror");
        		exit();
        	}
        	else
        	{
        	    mysqli_stmt_bind_param($stmt,"s",$pom);	//urceni parametru, ktere chceme updatovat
		        mysqli_stmt_execute($stmt);	//provedeni dotazu
        	}
        }
    	if($_SESSION['poziceUzivatele'] != "Administrátor"){
    	   header("Location: ../pages/objednavky");
    	   exit();
		}
		else{
		   header("Location: ../pages/menu?objednavky");
    	   exit(); 
		}
	}
}
else if(isset($_POST['smazatObj']))
{
    $idObjednavky=$_POST['idObjednavkyHidden'];
	$sqlObj = "SELECT * FROM `objednavkySklad` WHERE id=$idObjednavky;";
    $vysObj = mysqli_query($pripojeni,$sqlObj);
    $rowObj = mysqli_fetch_assoc($vysObj);
    
    $sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky=$idObjednavky;";
    $vysVec = mysqli_query($pripojeni,$sqlVec);
    while($rowVec = mysqli_fetch_assoc($vysVec)){
        $idVeci=$rowVec['idVeci'];
        
        $sqlSklad = "SELECT * FROM `skladiste` WHERE id=$idVeci;";
        $vysSklad = mysqli_query($pripojeni,$sqlSklad);
        $rowSklad = mysqli_fetch_assoc($vysSklad);
        
        if($rowObj['stav'] == 4){
            $pom = $rowSklad['pocet'];
            $pom=$pom+$rowVec['pocetVeci'];
                    
            $sqla = "UPDATE skladiste SET pocet=? WHERE id='$idVeci';";
            $stmta = mysqli_stmt_init($pripojeni);
            if(!mysqli_stmt_prepare($stmta,$sqla)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
                header("Location: ../pages/menu?error=sqlerror");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmta,"s",$pom);	//urceni parametru, ktere chceme updatovat
        		mysqli_stmt_execute($stmta);	//provedeni dotazu¨
        		        
        		$sql = "DELETE FROM objednavkySklad WHERE id=?;";
                $stmt = mysqli_stmt_init($pripojeni);
                if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
                    header("Location: ../pages/menu?error=sqlerror");
                    exit();
                }else{
                    $sqlb = "DELETE FROM objednavkySklad_veci WHERE id=?;";     //maze vse z tabulky objednavkySklad
                    $stmtb = mysqli_stmt_init($pripojeni);
                    if(!mysqli_stmt_prepare($stmtb,$sqlb)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
                    	header("Location: ../pages/menu?error=sqlerror");
                        exit();
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmtb,"s",$idObjednavky);	//urceni parametru, ktere chceme updatovat
                        mysqli_stmt_execute($stmtb);	//provedeni dotazu
                        		
                        mysqli_stmt_bind_param($stmt,"s",$idObjednavky);	//urceni parametru, ktere chceme updatovat
                        mysqli_stmt_execute($stmt);	//provedeni dotazu
                        header("Location: ../pages/menu?obj==smazana");
                        exit();
                    }
            	}
            }
        }
        else
        {
            $sql = "DELETE FROM objednavkySklad WHERE id=?;";
            $stmt = mysqli_stmt_init($pripojeni);
            if(!mysqli_stmt_prepare($stmt,$sql)){	//mysqli_stmt_prepare pripravuje sql prikaz k provedeni ale pokud nelze z nejakeho duvodu provest - vyhodime error
                header("Location: ../pages/menu?error=sqlerror");
                exit();
            }else{
               	mysqli_stmt_bind_param($stmt,"s",$idObjednavky);	//urceni parametru, ktere chceme updatovat
                mysqli_stmt_execute($stmt);	//provedeni dotazu
                header("Location: ../pages/menu?obj==smazana");
                exit();
            }
        }
    }
}
?>
