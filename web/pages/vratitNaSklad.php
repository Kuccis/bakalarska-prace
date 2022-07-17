<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/kalendarStyle.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     $idUkolu=$_POST['idUkoluHidden'];
     $idObjednavky=$_POST['idObjednavkyHidden'];
     if(!isset($idObjednavky) || $_SESSION['poziceUzivatele'] == "nezadáno" || $_SESSION['poziceUzivatele'] == "Montér")
     {
        header("Location: ../pages/skladiste");
        exit();
     }
     include "includes/navbar.php";
       echo '
       <div class="kalendarContainer">
         <section class="text-center">
           <div class="row py-lg-5" style="margin-right:0px;">
             <div class="col-lg-6 col-md-8 mx-auto">';
               include "includes/errorVypis.php";
               echo '
               <h1 class="fw-light">Vrátit věci na sklad</h1>
               <p class="lead text-muted">V této sekci máte možnost vrátit vypůjčené věci zpět na sklad. Zkontrolujte si počet a druh vrácených věcí a následně vyplňte pole. </p>
             </div>
           </div>
           <h4>Původní objednávka</h4>
           <hr>
           <form action="../scripts/objednavkascr" method="POST">  
           <table class="table" style="vertical-align:middle; max-width:800px;margin-left:auto;margin-right:auto;">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Název</th>
                          <th scope="col">Počet</th>
                        </tr>
                      </thead>
                      <tbody>';
                           $sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky=$idObjednavky;";
                           $vysVec = mysqli_query($pripojeni,$sqlVec);
                           while($rowVec = mysqli_fetch_assoc($vysVec)){
                               $idProFoto=$rowVec['idVeci'];
                               $sqlFoto = "SELECT * FROM `skladiste` WHERE id=$idProFoto;";
                               $vysFoto = mysqli_query($pripojeni,$sqlFoto);
                               $rowFoto = mysqli_fetch_assoc($vysFoto);
                               echo '
                               <tr>';
                                if($rowFoto['foto']==0)
                                 echo '<th scope="row"><img src="../photos/items/defaultItem.jpg" style="width:100px;height:70px;"></th>';
                                else
                                {
                                  $filename="../photos/items/item".$rowFoto['id']."*";
                                  $fileinfo=glob($filename);
                                  $fileext=explode(".",$fileinfo[0]);
                                 echo '<th scope="row"><img src="../photos/items/item'.$rowFoto['id'].'.'.$fileext[3].'" style="width:100px;height:70px;"></th>';    
                                }
                                echo '
                                 <td>'.$rowFoto['nazev'].'</td>
                                 <input type="hidden" name="idObjednavkyHidden" value="'.$idObjednavky.'">
                                 <input type="hidden" name="idUkoluHidden" value="'.$idUkolu.'">
                                 <td><input type="text" style="text-align:center;" disabled value="'.$rowVec['pocetVeci'].'" size="3" /></td>
                               </tr>';
                           }
                      echo '
                      </tbody>
            </table>
            <!-- Button trigger modal A-->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">
                Vrátit věci na sklad
            </button>
            <hr>
            
         </section>
       </div>
       <!-- Modal ZOBRAZENI -->
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
               <div class="modal-dialog" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Jste si jistí, že chcete tento počet věcí vrátit na sklad?</h5>
                   </div>
                 <div class="modal-body">
                    Před tím než kliknete na tlačítko <b>vrátit na sklad</b>, se ujistěte, že jste vše řádně pročetl/a a že se vším souhlasíte.<br><br>Vaše změny nebude možné vrátit zpět!
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                    <button type="submit" name="vratitSubmit" class="btn btn-success">Vrátit na sklad</button>
                 </div>
                </div>
               </div>
            </div>
       </form>';
    ?>
</body>
</html>
