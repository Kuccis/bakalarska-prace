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
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
    if($_SESSION['poziceUzivatele'] != "Šéf" && $_SESSION['poziceUzivatele'] != "Administrátor"){
        header("Location: ../pages/uvod");
        exit();
    }
    else{
       include "includes/navbar.php";
       $sql = "SELECT * FROM `nastaveniMenu` WHERE nazev='Montér';";
       $vys = mysqli_query($pripojeni,$sql);
       $row = mysqli_fetch_assoc($vys);
       
       $sqla = "SELECT * FROM `nastaveniMenu` WHERE nazev='Skladník';";
       $vysa = mysqli_query($pripojeni,$sqla);
       $rowa = mysqli_fetch_assoc($vysa);
       
       $sqlb = "SELECT * FROM `nastaveniMenu` WHERE nazev='Šéf';";
       $vysb = mysqli_query($pripojeni,$sqlb);
       $rowb = mysqli_fetch_assoc($vysb);
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">';
         include "includes/errorVypis.php";
         echo '
         <h1 class="fw-light">Editace sazeb</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">Tento editor slouží k úpravě sazeb u jednotlivých rolí. Všechny hodnoty jsou uváděné v Kč!
           </p>
         </div>
         <div class="pozadiSef">
         <form method="POST" action="../scripts/editSazbu">
             <div class="menuUloha">
               <h5>Montér</h5>
               <input type="text" style="max-width: 200px;margin-left: auto;margin-right: auto;" class="form-control" name="monter" value="'.$row['cena'].'" placeholder="Zadejte sazbu pro roli montér"><br>
               <h5>Skladník</h5>
               <input type="text" style="max-width: 200px;margin-left: auto;margin-right: auto;" class="form-control" name="skladnik" value="'.$rowa['cena'].'" placeholder="Zadejte sazbu pro roli skladník"><br>
               <h5>Šéf</h5>
               <input type="text" style="max-width: 200px;margin-left: auto;margin-right: auto;" class="form-control" name="sef" value="'.$rowb['cena'].'" placeholder="Zadejte sazbu pro roli šéf"><br>
             </div>
             <br>
             <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
               <button type="submit" name="submitSazba" class="btn btn-primary px-4 gap-3">Editovat sazbu</button>
               <a href="" type="button" class="btn btn-outline-secondary px-4">Report</a>
             </div>
         </form>
         <br>
         </div>
       </div>
       ';
    }
    ?>
</body>
</html>
