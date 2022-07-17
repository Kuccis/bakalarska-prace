<?php
session_start();
include_once 'dtb.php';

$idVecHidden=$_POST['idVecHidden'];
$nazevVec=$_POST['nazevVec'];
$pocetVec=$_POST['pocetVec'];
$jednotka=$_POST['jednotka'];
$cena = $_POST['cenaVec'];
$sekce=$_POST['sekceVec'];
$text=$_POST['textUlohy'];
$datum = date("Y-m-d");

if(isset($_POST['submitEdit'])){
  if(empty($nazevVec)){
    header("Location: ../pages/editorVec?nazevPrazdny=vec".$idVecHidden);
    exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
  }
  else if(empty($pocetVec)){
    header("Location: ../pages/editorVec?pocetPrazdny=vec".$idVecHidden);
    exit();
  }
  else if(empty($cena)){
    header("Location: ../pages/editorVec?cenaPrazdny=vec".$idVecHidden);
    exit();
  }
  else {
    $sql = "UPDATE skladiste SET nazev=?,text=?,pocet=?,ksm=?,sekce=?,cena=? WHERE id = $idVecHidden;";
    $stmt = mysqli_stmt_init($pripojeni);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/skladiste?error=sqlerror");
      exit();
    }else{
      
      if($_FILES['foto']['name']==''){
        mysqli_stmt_bind_param($stmt,"ssssss",$nazevVec,$text,$pocetVec,$jednotka,$sekce,$cena);
        mysqli_stmt_execute($stmt);
        header("Location: ../pages/skladiste?editace==uspesna");
        exit();
      }
      else{
      $sqli = "SELECT * FROM `skladiste` WHERE id=$idVecHidden;";
      $vysi= mysqli_query($pripojeni,$sqli);
      $rowi = mysqli_fetch_assoc($vysi);

      $foto = $_POST['foto'];
      $fotoJmeno = $_FILES['foto']['name'];   // $files - globalni promenna, foto - jmeno z inputu, name - nwm
      $fotoTmp = $_FILES['foto']['tmp_name'];  // tmp - jakoze umisteni
      $fotoVelikost = $_FILES['foto']['size'];
      $fotoError = $_FILES['foto']['error'];
      $fotoTyp = $_FILES['foto']['type'];

      $fotoExt = explode('.', $fotoJmeno); //rozdeleni jmena za ucelem zjisteni koncovky souboru (v mem pripade jpg). Vlastne rozdelime fotoJmeno na pole ve kterem bude jmeno a koncovku
      $fotoPismoExt = strtolower(end($fotoExt));  //pokud se nahraje foto, ktera ma koncovku psanou velkym pismem - timto prikazem se zmeni vsechna velka pismena na mala.

      $povoleno = array('jpg','jpeg','png');

        if(in_array($fotoPismoExt, $povoleno)){ //in_array zjisti zda-li pole se jmeneme a koncovkou fotky obsahuje mnou zadane koncovky v promene $povoleno
  	      if($fotoError == 0){ //pokud neni zadny problem u nahravani fotky {fotka neni jakkoliv vadna napr vetsi nez je pozadovana, jiny typ atd.}
  	        if($fotoVelikost < 5000000){  // 5 000 000 = 5mb
              if($rowi['foto']==1)
              {
                $jmenoFoto="../photos/items/item".$idVecHidden."*";
                $fotoinfo=glob($jmenoFoto);
                $fotoext=explode(".",$fotoinfo[0]);
                $fotoKonc=$fotoext[3];

                $foto = "../photos/items/item".$idVecHidden.".".$fotoKonc;

                 if(!unlink($foto)){
                 }
              }

              $fotoNoveJmeno = "item".$idVecHidden.".".$fotoPismoExt; //vyrobi unikatni jmeno. Delame to protoze se muze stat, ze by dva uzivatele chteli nahrat stejne jmeno fotky napr. foto.jpg. Pokud by se tak stalo tak by se fotka ve slozce prepsala a zmizela.
  	          $fotoUmisteni = '../photos/items/' . $fotoNoveJmeno;
  	          move_uploaded_file($fotoTmp,$fotoUmisteni);
  	          $sqla = "UPDATE skladiste SET foto=1 WHERE id = '$idVecHidden';";
  	          $vysa = mysqli_query($pripojeni,$sqla);
              mysqli_stmt_bind_param($stmt,"ssssss",$nazevVec,$text,$pocetVec,$jednotka,$sekce,$cena);
              mysqli_stmt_execute($stmt);
              header("Location: ../pages/skladiste?editace==uspesna");
              exit();
  	        }
            else {
              header("Location: ../pages/editorVec?vec".$idVecHidden."#foto==velikost");
    	        exit();
            }
  	      }
          else {
            header("Location: ../pages/editorVec?vec".$idVecHidden."#foto=error");
    	      exit();
          }
  	    }
        else {
          header("Location: ../pages/editorVec?vec".$idVecHidden."#foto==typ");
          exit();
        }
      //*************************************************************************************************
      }
     }
   }
}
?>
