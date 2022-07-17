<?php
session_start();
include_once 'dtb.php';

if(isset($_POST['submitVec'])){
    $idUziv=$_SESSION['idUzivatele'];
    $nazevVec=$_POST['nazevVec'];
    $pocetVec=$_POST['pocetVec'];
    $jednotka=$_POST['vecJednotka'];
    $sekce=$_POST['vecSekce'];
    $text=$_POST['textVeci'];
    $datum = date("Y-m-d");
    $cena = $_POST['cenaVec'];
    
	  $sql="INSERT INTO skladiste (nazev,text,pocet,ksm,sekce,datumPridani,cena) VALUES (?,?,?,?,?,?,?)";
	  $stmt = mysqli_stmt_init($pripojeni);
	  if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../pages/index?error=sqlerror");
			exit();
	  }
    else if(empty($nazevVec))
    {
      header("Location: ../pages/skladPridat?nazev==nezadan");
  		exit();
    }
    else if(empty($pocetVec))
    {
      header("Location: ../pages/skladPridat?pocet==nezadan");
  		exit();
    }
    else if(empty($cena))
    {
        header("Location: ../pages/skladPridat?cena==nezadana");
  		exit();
    }
    else if(empty($jednotka))
    {
      header("Location: ../pages/skladPridat?jednotka==nezadan");
  		exit();
    }
    else if(empty($sekce))
    {
      header("Location: ../pages/skladPridat?sekce==nezadan");
  		exit();
    }
	  else{
		mysqli_stmt_bind_param($stmt, "sssssss",$nazevVec,$text,$pocetVec,$jednotka,$sekce,$datum,$cena);
		mysqli_stmt_execute($stmt);

			$foto = $_POST['foto'];
			$sqli="SELECT * FROM skladiste ORDER BY id DESC LIMIT 1;";
	    $vysi = mysqli_query($pripojeni,$sqli);
	    $rowi=mysqli_fetch_assoc($vysi);

	    $idVeci=$rowi['id'];


	    $fotoJmeno = $_FILES['foto']['name'];   // $files - globalni promenna, foto - jmeno z inputu, name - nwm
	    $fotoTmp = $_FILES['foto']['tmp_name'];  // tmp - jakoze umisteni
	    $fotoVelikost = $_FILES['foto']['size'];
	    $fotoError = $_FILES['foto']['error'];
	    $fotoTyp = $_FILES['foto']['type'];

	    $fotoExt = explode('.', $fotoJmeno); //rozdeleni jmena za ucelem zjisteni koncovky souboru (v mem pripade jpg). Vlastne rozdelime fotoJmeno na pole ve kterem bude jmeno a koncovku
	    $fotoPismoExt = strtolower(end($fotoExt));  //pokud se nahraje foto, ktera ma koncovku psanou velkym pismem - timto prikazem se zmeni vsechna velka pismena na mala.

	    $povoleno = array('jpg','jpeg','png');

	    if(in_array($fotoPismoExt, $povoleno)){ //in_array zjisti zda-li pole se jmeneme a koncovkou fotky obsahuje mnou zadane koncovky v promene $povoleno
	      if($fotoError === 0){ //pokud neni zadny problem u nahravani fotky {fotka neni jakkoliv vadna napr vetsi nez je pozadovana, jiny typ atd.}
	        if($fotoVelikost < 5000000){  // 5 000 000 = 5mb
	          $fotoNoveJmeno = "item".$idVeci.".".$fotoPismoExt; //vyrobi unikatni jmeno. Delame to protoze se muze stat, ze by dva uzivatele chteli nahrat stejne jmeno fotky napr. foto.jpg. Pokud by se tak stalo tak by se fotka ve slozce prepsala a zmizela.
	          $fotoUmisteni = '../photos/items/' . $fotoNoveJmeno;
	          move_uploaded_file($fotoTmp,$fotoUmisteni);

	          $sqla = "UPDATE skladiste SET foto=1 WHERE id = '$idVeci';";
	          $vysa = mysqli_query($pripojeni,$sqla);

	          header("Location: ../pages/skladiste?vecPridana==uspesne");
	          exit();
	        }
	        header("Location: ../pages/skladiste?foto==velikost");
	        exit();
	      }
	      header("Location: ../pages/skladiste?foto==typ");
	      exit();
	    }
			header("Location: ../pages/skladiste");
			exit();
	  }
	}
?>
