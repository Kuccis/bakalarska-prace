<?php
			if(isset($_POST['registrace'])){
				 require 'dtb.php';

				 $jmenoUzivatele = $_POST['jmeno'];
                 $prijmeniUzivatele = $_POST['prijmeni'];
                 $teliUzivatele = $_POST['telcis'];
				 $emailAdresa = $_POST['email'];
				 $hesloJedna = $_POST['heslo1'];
				 $hesloDve=$_POST['heslo2'];
				 $gdpr=$_POST['gdprCheck'];
				 $datum=date("Y-m-d");

				if(empty($jmenoUzivatele) || empty($emailAdresa) || empty($hesloJedna) || empty($hesloDve) || empty($teliUzivatele) || empty($prijmeniUzivatele)){
					header("Location: ../pages/registrace?error=prazdnekolonky");
					exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
				}
				else if(!isset($_POST['gdprCheck']) && $gdpr != 'souhlasim_se_zpracovanim_udaju'){
					header("Location: ../pages/registrace?error=gdprproblem");
					exit();
				}
				else if(!filter_var($emailAdresa,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$jmenoUzivatele)){
					header("Location: ../pages/registrace?error=spatnezadanyemailajmeno");
					exit();
				}
				else if(!filter_var($emailAdresa,FILTER_VALIDATE_EMAIL)){
					header("Location: ../pages/registrace?error=spatnezadanyemail");
					exit();
				}
				else if(!preg_match("/^[a-žA-Ž0-9]*$/",$jmenoUzivatele)){
					header("Location: ../pages/registrace?error=spatnezadejmeno");
					exit();
				}
				else if($hesloJedna !== $hesloDve){
					header("Location: ../pages/registrace?error=heslanejsoustejna");
					exit();
				}
				else if(strlen($hesloJedna) < 7){
					header("Location: ../pages/registrace?error=heslojekratke");
					exit();
				}
				else {
					$sql="SELECT * FROM uzivatele WHERE email=?;";
					$stmt = mysqli_stmt_init($pripojeni);		//Funkce mysqli_stmt_init () inicializuje příkaz a vrátí objekt vhodný pro mysqli_stmt_prepare ().
					if(!mysqli_stmt_prepare($stmt,$sql)){
						header("Location: ../index?error=sqlerror");
						exit();
					}else{
						mysqli_stmt_bind_param($stmt, "s", $emailAdresa);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);	//Převede sadu výsledků z posledního dotazu
						$pocet = mysqli_stmt_num_rows($stmt);

						if($pocet > 0){
							header("Location: ../index?error=emailjezabrany");
							exit();
						}else{
							$sql="INSERT INTO uzivatele (jmeno,prijmeni,telcis,email,heslo,profilovka,gdpr,datumRegistrace) VALUES (?,?,?,?,?,0,?,?)";	//ochrana (proti sql injection)
							$stmt = mysqli_stmt_init($pripojeni);
							if(!mysqli_stmt_prepare($stmt,$sql)){
								header("Location: ../index?error=sqlerror");
								exit();
							}
							else{
								//registrace ulozeni do databaze
								$hasHesla=password_hash($hesloJedna, PASSWORD_DEFAULT);
								mysqli_stmt_bind_param($stmt, "sssssss", $jmenoUzivatele,$prijmeniUzivatele,$teliUzivatele,$emailAdresa,$hasHesla,$gdpr,$datum);
								mysqli_stmt_execute($stmt);
								header("Location: ../index?registraceuspesna=success");
								exit();
							}
						}
					}
					}
				mysqli_stmt_close($stmt);
				mysqli_close($pripojeni);
			}
			else {
				header("Location: ../index.php");
				exit();
      }
?>
