<?php
	if(isset($_POST['zmenHeslo'])){
		require 'dtb.php';
        $idUzivatele=$_POST['idUzivatele'];
        $heslo1=$_POST['heslo1'];
        $heslo2=$_POST['heslo2'];
        if(empty($heslo1)){
            header("Location: ../pages/nastaveni?error=hesloPrazdne");
			exit();
        }
        else if(empty($heslo2)){
            header("Location: ../pages/nastaveni?error=hesloDvePrazdne");
			exit();
        }
		else if(strlen($heslo1) < 7){
			header("Location: ../pages/nastaveni?error=heslojekratke");
			exit();
		}
		else if($heslo1 !== $heslo2){
			header("Location: ../pages/nastaveni?error=heslaNejsouStejna");
			exit();
		}
        else
        {
            $sql="UPDATE uzivatele SET heslo=? WHERE id=$idUzivatele";	//ochrana (proti sql injection)
		    $stmt = mysqli_stmt_init($pripojeni);
			if(!mysqli_stmt_prepare($stmt,$sql)){
				header("Location: ../pages/nastaveni?error=sqlerror");
				exit();
			}
			else
			{
			    $hasHesla=password_hash($heslo1, PASSWORD_DEFAULT);
			    mysqli_stmt_bind_param($stmt, "s", $hasHesla);
				mysqli_stmt_execute($stmt);
				header("Location: ../pages/nastaveni?heslo==zmeneno");
				exit();
			}
        }
	}
?>