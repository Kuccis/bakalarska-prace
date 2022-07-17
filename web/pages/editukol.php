<?php
	session_start();
	include_once '../scripts/dtb.php'
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/uvodStyle.css">
    <script src="https://cdn.tiny.cloud/1/eoj1vdl030re3i765qa6n3j57jqfnns3nr0518tqoi0f9cvl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Vítejte v Javosoftware!</title>
    <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });
  </script>
</head>
<body>
    <?php
     if($_SESSION['poziceUzivatele']=="Šéf" ||  $_SESSION['poziceUzivatele']=="Administrátor"){
         include "includes/navbar.php";
         $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
         $idUkoluHidden=substr($celaURL, strrpos($celaURL, 'l')+1);
         $sqli = "SELECT *  FROM `ukoly` WHERE id=$idUkoluHidden;";
         $vysi= mysqli_query($pripojeni,$sqli);
         $rowi = mysqli_fetch_assoc($vysi);
           echo '
           <div id="uvodniTextikk" class="px-4 my-5 text-center">';
             include "includes/errorVypis.php";
             echo '
             <h1 class="fw-light">Editor úloh</h1>
             <div class="col-lg-6 mx-auto">
               <p class="lead mb-4 text-muted">Tento editor slouží k upravení zadaného úkolu. V případě, že dojde k hlavním změnám pro jistotu uvědomte Vašeho pracovníka! Nemusel by si změn všimnout.
               </p>
             </div>
             <div class="pozadiSef">
             <form method="POST" action="../scripts/editUkol" class="formEdit">
             <div class="menuUloha">
               <input type="hidden" name="idUkoluHidden" value="'.$idUkoluHidden.'">
               <input type="text" class="form-control" id="nazevUkolu" name="nazevUkolu" value="'.$rowi['nazev'].'" placeholder="Zadejte název úkolu *"><br>
               <input type="text" class="form-control" name="osfir" value="'.$rowi['osfir'].'" placeholder="Zadejte osobu/firmu, pro kterou se úkol dělá"><br>
               <input type="text" class="form-control" name="mesto" value="'.$rowi['mesto'].'" placeholder="Zadejte město (např. Brno)"><br>
               <input type="text" class="form-control" name="ulice" value="'.$rowi['ulice'].'" placeholder="Zadejte ulici (např. Kounicova)"><br>
               <input type="text" class="form-control" name="psc" value="'.$rowi['psc'].'" placeholder="Zadejte PSČ (např. 380 00)"><br>
               <input type="text" class="form-control" name="cp" value="'.$rowi['cp'].'" placeholder="Zadejte číslo popisné (pouze číslo)"><br>
               <input type="text" class="form-control" name="odkdy" value="'.$rowi['odkdy'].'" placeholder="Od kdy (např. 27.01.2022)"><br>
               <input type="text" class="form-control" name="dokdy" value="'.$rowi['dokdy'].'" placeholder="Do kdy (např. 27.02.2022)"><br>
               <select class="form-control" name="zamestnanec"><br>
                <option value="">Vyberte zaměstnance *</option>';
                  //Vypis vsech zamestancu s roli monter nebo skladnik
                 $sql = "SELECT *  FROM `uzivatele` WHERE pozice='Montér' OR pozice='Skladník';"; 	//limit - max int
                 $vys= mysqli_query($pripojeni,$sql);
                 while($row = mysqli_fetch_assoc($vys))
                 {
                   if($rowi['zadany_monter_id']==$row['id'])
                    echo '<option selected="selected" value="'.$row['id'].'">'.$row['jmeno'].' '.$row['prijmeni'].' - '.$row['pozice'].'</option>';
                    else {
                      echo '<option value="'.$row['id'].'">'.$row['jmeno'].' '.$row['prijmeni'].' - '.$row['pozice'].'</option>';
                    }
                 }
               echo '</select><br>
               <textarea name="textUlohy">
                '.$rowi['textUlohy'].'
               </textarea>
             </div>
             <br>
             <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
               <button type="submit" name="submitUloha" class="btn btn-primary px-4 gap-3">Editovat úlohu</button>
               <a href="kalendar" type="button" class="btn btn-outline-secondary px-4">Zpět</a>
             </div>
             </form>
             <br>
             </div>
           </div>
           ';
     }
     else
     {
        header("Location: ../pages/kalendar");
        exit();
     }
    ?>
</body>
</html>
