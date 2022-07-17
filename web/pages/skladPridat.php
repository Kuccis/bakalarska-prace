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
     //test jestli bylo stisknuto tlacitko pro pridani do skladiste. Toto tlacitko vidi pouze uzivatel s roli sef, admin a skladnik
    if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Skladník" || $_SESSION['poziceUzivatele']=="Administrátor")
    {
       include "includes/navbar.php";
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">';
            include "includes/errorVypis.php";
        echo'
         <h1 class="fw-light">Přidat novou věc do skladu</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">Tento editor slouží k přidání nové věci do skladiště. Nezapomeňte si vše před přidáním řádně zkontrolovat. Mohlo by dojít k vážným problémům! (např. špatné vyučtování, chybný počet)
           </p>
         </div>
         <div class="pozadiSef">
         <form method="POST" enctype="multipart/form-data" action="../scripts/pridejVec" class="formEdit">
         <div class="menuUloha">
           Fotografie lze nahrát pouze ve formáte jpg, jpeg, png. Maximální velikost je 5mb!
           <br><br>
           Vyberte fotografii -
           <input type="file" name="foto">
           <br><br>
           <input type="text" class="form-control" id="nazevVec" name="nazevVec" placeholder="Zadejte název věci *"><br>
           <input type="text" class="form-control" name="pocetVec" placeholder="Zadejte počet (ks,m,cm.. pouze číslem)"><br>
           <input type="text" class="form-control" id="nazevVec" name="cenaVec" placeholder="Zadejte cenu věci v Kč(za ks, m, dle zadané jednotky)"><br>
           <select class="form-control" name="vecJednotka"><br>
            <option value="">Vyberte jednotku, ve které se věc zapisuje (např. m-metrech) *</option>
            <option value="ks">ks (kus/ů)</option>
            <option value="m">m (metr/ů)</option>
            <option value="cm">cm (centimetr/ů)</option>
           </select>
           <br>
           <select class="form-control" name="vecSekce"><br>
            <option value="">Vyberte sekci, do které se věc zařadí *</option>
            <option value="1">Elektrické nářadí</option>
            <option value="2">Nářadí</option>
            <option value="3">Switche</option>
            <option value="4">Routery</option>
            <option value="5">Elektroinstalace</option>
            <option value="6">Lana, provazy, hřebíky, ..</option>
            <option value="7">Zabezpečení</option>
            <option value="8">Dráty, konektory a další</option>
            <option value="9">Ostatní</option>
           </select>
           <br>
           <textarea name="textVeci">
           </textarea>
         </div>
         <br>
         <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
           <button type="submit" name="submitVec" class="btn btn-primary px-4 gap-3">Přidat věc do skladiště</button>
           <a href="skladiste" type="button" class="btn btn-outline-secondary px-4">Zpět</a>
         </div>
         </form>
         <br>
         </div>
       </div>
       ';
    }
     else {
       header("Location: ../pages/skladiste");
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
