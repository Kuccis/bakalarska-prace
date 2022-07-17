<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/uvodStyle.css">
    <link rel="stylesheet" href="../css/skladStyle.css">
    <title>Poslední krok objednávky</title>
</head>
<body>
    <?php
     include "includes/navbar.php";
     echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">';
         include "includes/errorVypis.php";
         echo '
         <i class="fa-solid fa-cart-shopping fa-6x"></i>
         <h1 class="display-5 fw-light">Poslední krok objednávky</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">
            Před odesláním objednávky se ujistěte, že máte vše potřebné. Poté co objednávku odešlete už není možné dělat změny.
           </p>
         </div>';
         if(isset($_SESSION['idVeci'])){
                echo '
                
                <form action="../scripts/objednatVeci" method="POST">
                  <table class="table" style="vertical-align:middle; max-width:800px;margin-left:auto;margin-right:auto;">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Název</th>
                          <th scope="col">Počet</th>
                        </tr>
                      </thead>
                      <tbody>';
                        foreach($_SESSION['idVeci'] as $cisloVeci)
                        {
                           $idVeci=$cisloVeci["id"];
                           $sqlVec = "SELECT * FROM `skladiste` WHERE id=$idVeci;";
                           $vysVec = mysqli_query($pripojeni,$sqlVec);
                           
                           while($rowVec = mysqli_fetch_assoc($vysVec)){
                           echo '
                           <tr>';
                            if($rowVec['foto']==0)
                             echo '<th scope="row"><img src="../photos/items/defaultItem.jpg" style="width:100px;height:70px;"></th>';
                            else
                            {
                              $filename="../photos/items/item".$rowVec['id']."*";
                              $fileinfo=glob($filename);
                              $fileext=explode(".",$fileinfo[0]);
                             echo '<th scope="row"><img src="../photos/items/item'.$rowVec['id'].'.'.$fileext[3].'" style="width:100px;height:70px;"></th>';    
                            }
                            echo '
                             <td>'.$rowVec['nazev'].'</td>
                             <td><input type="text" class="vecPoc" disabled value="'.$cisloVeci['pocet'].'" size="3" /></td>
                           </tr>';
                           }
                        }
                      echo '
                        
                      </tbody>
                    </table>';  
                    }
                    else
                    {
                        echo "V košíku není přidané zboží";
                    }
                    echo '
                 <select name="postIdUkol" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="vertical-align:middle; max-width:800px;margin-left:auto;margin-right:auto;">
                    <option selected>Přiřadit úkol, ke kterému si půjčujete věci</option>';
                    $idUz=$_SESSION['idUzivatele'];
                    $sqlUkol = "SELECT * FROM `ukoly` WHERE zadany_monter_id='$idUz' AND stav='probihajici';";
                    $vysUkol = mysqli_query($pripojeni,$sqlUkol);
                    while($rowUkol = mysqli_fetch_assoc($vysUkol)){
                        $datum = strtotime($rowUkol['datum']);
                        echo '<option value="'.$rowUkol['id'].'">'.$rowUkol['nazev']." - ".date('d.m.Y', $datum).'</option>';
                    }
                    echo '
                 </select>
                 <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4">
                   <a href="skladiste" type="button" class="btn btn-secondary">Zpět do skladiště</a>
                   ';
                   if(isset($_SESSION['idVeci']))
                    echo '<button type="submit" name="odeslatObjednavku" class="btn btn-primary">Odeslat objednávku</a>';
                   else
                    echo '<button type="submit" class="btn btn-primary disabled">Odeslat objednávku</a>';
                   echo '
                 </div>
                </form>
        </div>
       </div>';
    ?>
</body>
</html>
