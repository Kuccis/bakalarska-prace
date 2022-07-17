<?php
session_start();
include_once 'dtb.php';

$pole=$_SESSION['idVeci'];
$idUkolu=$_POST['postIdUkol'];
$idUzivatele=$_SESSION['idUzivatele'];


if(isset($_POST['odeslatObjednavku'])){
    if(!empty($_SESSION['idVeci'])){
        if(!empty($idUkolu) && $idUkolu!=0){
            $datum = date("Y-m-d");
        	$sqla="INSERT INTO objednavkySklad (idUkolu, odeslal_id, datum) VALUES (?,?,?);";
        	$stmt = mysqli_stmt_init($pripojeni);
        	if(!mysqli_stmt_prepare($stmt,$sqla)){
        	    header("Location: ../pages/skladiste?error=sqlerror");
                exit();
        	}
        	else{
        	    mysqli_stmt_bind_param($stmt,"sss",$idUkolu,$idUzivatele, $datum);
                mysqli_stmt_execute($stmt);
                $last_id = mysqli_insert_id($pripojeni);
        	}
        	
        	foreach($_SESSION['idVeci'] as $i => $k)
        	{
        	    $sql="INSERT INTO objednavkySklad_veci (idVeci,pocetVeci,idObjednavky) VALUES (?,?,?)";
        	    $stmt = mysqli_stmt_init($pripojeni);
        	    if(!mysqli_stmt_prepare($stmt,$sql)){
        	        header("Location: ../pages/skladiste?error=sqlerror");
                    exit();
        	    }
        	    else{
            	    mysqli_stmt_bind_param($stmt,"sss",$pole[$i]["id"],$pole[$i]["pocet"],$last_id);
                    mysqli_stmt_execute($stmt);
        	    }
        	}
        	unset($_SESSION['idVeci']);
        	header("Location: ../pages/skladiste?objednavka==uspesna");
            exit();
        }
        else
        {
            header("Location: ../pages/skladisteFinal?ukol==nevyplnen");
            exit();
        }
    }
    else
    {
        header("Location: ../pages/skladiste?objednavka==nevyplnena");
        exit();
    }
}
?>
