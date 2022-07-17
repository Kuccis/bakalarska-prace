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
     include "includes/navbar.php";
     $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     if(strpos($celaURL,'objednavky') != false && strpos($celaURL,'objednavky?ukol') == false)
     {
           echo '
           <div class="kalendarContainer">
             <section class="text-center">
               <div class="row py-lg-5" style="margin-right:0px;">
                 <div class="col-lg-6 col-md-8 mx-auto">';
                   include "includes/errorVypis.php";
                   echo '
                   <h1 class="fw-light">Výpis Vašich objednávek</h1>
                   <p class="lead text-muted">
                      V této sekci najdete kompletní výpis Vašich objednávek. Každá objednávka zobrazuje aktuální stav i podrobnější informace po rozkliknutí.
                   </p>
                 </div>
               </div>
             </section>
           
               <div class="col-md-10 col-md-offset-1 mx-auto" style="margin-bottom:40px;">
    
                   <div class="panel panel-default panel-table">
                     <div class="panel-heading">
                       <div class="row" style="padding:8px 8px 0px 8px;">
                         <div class="col col-xs-6">
                           <h3 class="panel-title">Výpis všech objednávek</h3>
                         </div>
                       </div>
                     </div>
                     <div class="panel-body table-responsive">
                       <table class="table table-striped table-bordered table-list">
                         <thead>
                           <tr style="text-align: center;">
                               <th>ID</th>
                               <th>Název úkolu</th>
                               <th>Objednal</th>
                               <th>Datum objednávky</th>
                               <th>Stav objednávky</th>
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                         //-------------------------------------------Výpis do tabulky pro roli šéf,admin---------------------------------------------------------------
                         $cisloStrana = substr($celaURL, strrpos($celaURL, 'y')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                         $pomStrana=0;
                         if($cisloStrana == 1)
                    				$pomStrana = 0;
                    		 else if($cisloStrana > 1)
                    				$pomStrana = 10*$cisloStrana-10;
                    		 else
                    				$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku
    
                         $idUz=$_SESSION['idUzivatele'];
                         $sql = "SELECT * FROM `objednavkySklad` WHERE odeslal_id=$idUz ORDER BY id DESC LIMIT 10 OFFSET $pomStrana;";
                         $vys= mysqli_query($pripojeni,$sql);
                         $pocetObjednavek=mysqli_num_rows($vys);
    
                         if($pocetObjednavek > 0){
                           while($row = mysqli_fetch_assoc($vys))
                           {
                             $pom=$row['odeslal_id'];
                             $sqla = "SELECT * FROM `uzivatele` WHERE id=$pom"; 	//limit - max int
                             $vysa= mysqli_query($pripojeni,$sqla);
                             $rowa= mysqli_fetch_assoc($vysa);
                             
                             $pomi=$row['idUkolu'];
                             $sqli = "SELECT * FROM `ukoly` WHERE id=$pomi"; 	//limit - max int
                             $vysi= mysqli_query($pripojeni,$sqli);
                             $rowi= mysqli_fetch_assoc($vysi);
    
                             $datum = strtotime($row['datum']);
    
                             echo '
                                 <tr style="vertical-align: middle;text-align: center;">
                                   <td>'.$row['id'].'</td>
                                   <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$rowi['nazev'].'</a></td>';
                                   if($rowa['id'] == $pom)
                                     echo '<td>'.$rowa['jmeno']." ".$rowa['prijmeni'].'</td>';
                                   echo '<td>'.date('d.m.Y', $datum).'</td>';
                                   if($row['stav'] == 2)
                                     echo '<td style="color:red;font-weight: bold;">ZAMÍTNUTO</td>';
                                   else if($row['stav'] == 1)
                                     echo '<td style="color:green;font-weight: bold;">SCHVÁLENO</td>';
                                   else if($row['stav'] == 0)
                                     echo '<td style="color:gray;font-weight: bold;">NEVYŘÍZENO</td>';
                                   else if($row['stav'] == 3)
                                     echo '<td style="color:orange;font-weight: bold;">SCHVÁLENO - NEVYDÁNO</td>';
                                   else if($row['stav'] == 4)
                                     echo '<td style="color:green;font-weight: bold;">SCHVÁLENO - VYDÁNO</td>';
                                   else if($row['stav'] == 5)
                                     echo '<td style="color:green;font-weight: bold;">SCHVÁLENO - VRÁCENO</td>';
                                   else if($row['stav'] == 6)
                                     echo '<td style="color:red;font-weight: bold;">SCHVÁLENO - NEVRÁCENO</td>';
                             echo  '</tr>';
                           }
                       }
                       else {
                         echo '
                             <tr>
                               <td colspan="10">
                                 Žádný úkol nebyl zadán
                               </td>
                             </tr>';
                       }
                         echo   '</tbody>
                       </table>
                     </div>
                     <div class="panel-footer">
                       <div class="row" style="padding-right:8px;">
                       <nav aria-label="Page navigation example" style="float:right;">
                         <ul class="pagination justify-content-end">';
                         if($cisloStrana == 1)
                         {
                           //zajistuje ze se nelze vracet do minus hodnot
                           echo '
                           <li class="page-item disabled">
                             <a class="page-link">Předchozí</a>
                           </li>';
                         }
                         else if($cisloStrana > 1)
                         {
                           echo '
                           <li class="page-item">
                             <a class="page-link" href="vaseobjednavky?sty'.($cisloStrana-1).'">Předchozí</a>
                           </li>';
                         }
                         else {
                           //zajistuje ze se nelze vracet do minus hodnot
                           echo '
                           <li class="page-item disabled">
                             <a class="page-link">Předchozí</a>
                           </li>';
                         }
                         //----------------------------------------------------------------------VYPIS JEDNOTLIVE------------------------------------------
                        $sqlu = "SELECT * FROM objednavkySklad";
     					$vysu=mysqli_query($pripojeni,$sqlu);
     					$vsechnyUkolyPocet = mysqli_num_rows($vysu);
    
                        if($vsechnyUkolyPocet < 10)
     						$_SESSION['pocetStran']=($vsechnyUkolyPocet/10) + 1;
     					else if($vsechnyUkolyPocet == 10)
     						$_SESSION['pocetStran']=($vsechnyUkolyPocet/10);
     					else
     						$_SESSION['pocetStran']=($vsechnyUkolyPocet/10) + 1;
     					$pomKontrola=0;
                        if($cisloStrana == 1)
     						echo '<li class="page-item disabled"><a class="page-link" href="vaseobjednavky?sty1">1</a></li>';
                        else if($cisloStrana == "")
                            echo '<li class="page-item disabled"><a class="page-link" href="vaseobjednavky?sty1">1</a></li>';
                        else
                            echo '<li class="page-item"><a class="page-link" href="vaseobjednavky?sty1">1</a></li>';
    
     					for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                          if($cisloStrana == $i)
     						echo '<li class="page-item disabled"><a class="page-link" href="vaseobjednavky?sty'.$i.'">'.$i.'</a></li>';
                          else
                            echo '<li class="page-item"><a class="page-link" href="vaseobjednavky?sty'.$i.'">'.$i.'</a></li>';
     					  $pomKontrola=$i;
     					}
                        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
                        if($cisloStrana==$pomKontrola){
                          echo '<li class="page-item disabled">
                                  <a class="page-link">Další</a>
                                </li>';
                        }
                        else if($cisloStrana == "" || $cisloStrana=="?smazaniUkolu=uspesne" || $cisloStrana=="?smazaniUkolu=neuspesne" || $cisloStrana =="?editace==uspesna" || $cisloStrana =="?editace==neuspesna")
                        {
                          echo '<li class="page-item">
                                  <a class="page-link" href="?sty2">Další</a>
                                </li>';
                        }
                        else {
                          echo '<li class="page-item">
                                  <a class="page-link" href="vaseobjednavky?sty'.($cisloStrana+1).'">Další</a>
                                </li>';
                        }
                         echo '
                         </ul>
                       </nav>
                       </div>
                     </div>
                     </div>
                   </div>';
           echo '</div>';
     }
     else
     {
       //------------------------------VYPIS UKOLU NA CISTOU STRANKU, CISTA STRANKA ZAJISTENA POMOCI PODMINEK NA ODKAZY------------------------------
       $idObjednavky = substr($celaURL, strrpos($celaURL, 'l')+1);
       $sql = "SELECT *  FROM `objednavkySklad` WHERE id=$idObjednavky;"; 	//limit - max int
       $vys= mysqli_query($pripojeni,$sql);
       $row = mysqli_fetch_assoc($vys);
       $pocetObjednavek=mysqli_num_rows($vys);
           $idUkol=$row['idUkolu'];
           $idObjednavka=$row['id'];
           $sqlU = "SELECT * FROM `ukoly` WHERE id=$idUkol;";
           $vysU= mysqli_query($pripojeni,$sqlU);
           $rowU = mysqli_fetch_assoc($vysU);
           
           $idcko=$row['odeslal_id'];
           $sqli = "SELECT * FROM `uzivatele` WHERE id=$idcko;";
           $vysi= mysqli_query($pripojeni,$sqli);
           $rowi = mysqli_fetch_assoc($vysi);
            echo '
            <div class="kalendarContainer">
                
                <div class="row py-lg-5" style="margin-right:0px;">
                  <div class="col-md-10 mx-auto">
                  <div class="card-header">
                    <div class="ustify-content-between align-items-center">
                        <div class="ml-2">
                          <div class="leva">
                            <h4>Objednávka pro úkol: '.$rowU['nazev'].'</h4>
                            <p>Objednal/a: '.$rowi['jmeno'].' '.$rowi['prijmeni'].'</p>
                          </div>
                          <div class="prava">
                            <p>Stav objednávky: ';
                            if($row['stav'] == 2)
                                echo 'ZAMÍTNUTO';
                            else if($row['stav'] == 1)
                                echo 'SCHVÁLENO';
                            else if($row['stav'] == 0)
                                echo 'NEVYŘÍZENO';
                            else if($row['stav'] == 3)
                                echo 'SCHVÁLENO - NEVYDÁNO';
                            else if($row['stav'] == 4)
                                echo 'SCHVÁLENO - VYDÁNO';
                            else if($row['stav'] == 5)
                                echo 'SCHVÁLENO - VRÁCENO';
                            else if($row['stav'] == 6)
                                echo 'SCHVÁLENO - NEVRÁCENO';
                            echo '</p>
                            <p>Úkol je nutné vyřešit od: '.$rowU['odkdy'].' do: '.$rowU['dokdy'].'</p>
                        </div>
                        </div>
                    ';
                  echo '</div>
                  </div>
                  <div class="card-body" style="margin-top: 5px;margin-left:5px;margin-right:5px;word-break: break-all;">
                    <table class="table" style="vertical-align:middle; max-width:800px;margin-left:auto;margin-right:auto;">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Název</th>
                          <th scope="col">Počet</th>
                        </tr>
                      </thead>
                      <tbody>';
                           $sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky=$idObjednavka;";
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
                                 <td><input type="text" style="text-align:center;" disabled value="'.$rowVec['pocetVeci'].'" size="3" /></td>
                               </tr>';
                           }
                      echo '
                      </tbody>
                    </table>
                  </div>';
          }
    ?>
</body>
</html>
