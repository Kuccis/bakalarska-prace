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
</head>
<body>
    <?php
     if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Skladník" || $_SESSION['poziceUzivatele']=="Administrátor")
     {
        include "includes/navbar.php";
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">';
         include "includes/errorVypis.php";
         echo '
         <h1 class="fw-light">Vytvořit novou úlohu</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">Tento editor slouží k vytvoření kompletního zadání úlohy pro zaměstnance.
           Úspěšně zadaný úkol se automaticky zobrazí u přiděleného zaměstnance, není tedy třeba dalšího nastavování. Rychle a jednoduše!
           </p>
         </div>
         <div class="pozadiSef">
         <form method="POST" action="../scripts/zapisUkol" class="formEdit">
         <div class="menuUloha">
           <input type="text" class="form-control" id="nazevUkolu" name="nazevUkolu" placeholder="Zadejte název úkolu *"><br>
           <input type="text" class="form-control" name="osfir" placeholder="Zadejte osobu/firmu, pro kterou se úkol dělá"><br>
           <input type="text" class="form-control" name="mesto" placeholder="Zadejte město (např. Brno)"><br>
           <input type="text" class="form-control" name="ulice" placeholder="Zadejte ulici (např. Kounicova)"><br>
           <input type="text" class="form-control" name="psc" placeholder="Zadejte PSČ (např. 380 00)"><br>
           <input type="text" class="form-control" name="cp" placeholder="Zadejte číslo popisné (pouze číslo)"><br>
           <input type="text" class="form-control" name="odkdy" placeholder="Od kdy (např. 27.01.2022)"><br>
           <input type="text" class="form-control" name="dokdy" placeholder="Do kdy (např. 27.02.2022)"><br>
           <select class="form-control" name="zamestnanec"><br>
            <option value="">Vyberte zaměstnance *</option>';
              //Vypis vsech zamestancu s roli monter nebo skladnik
             $sql = "SELECT *  FROM `uzivatele` WHERE pozice='Montér' OR pozice='Skladník';"; 	//limit - max int
             $vys= mysqli_query($pripojeni,$sql);
             while($row = mysqli_fetch_assoc($vys))
             {
               echo '<option value="'.$row['id'].'">'.$row['jmeno'].' '.$row['prijmeni'].'</option>';
             }
           echo '</select><br>
           <textarea name="textUlohy">
           </textarea>
         </div>
         <br>
         <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
           <button type="submit" name="submitUloha" class="btn btn-primary px-4 gap-3">Zadat úlohu</button>
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
    <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });
  </script>
</body>
</html>
