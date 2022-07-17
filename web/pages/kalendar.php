<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <script src="https://cdn.tiny.cloud/1/eoj1vdl030re3i765qa6n3j57jqfnns3nr0518tqoi0f9cvl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="../css/kalendarStyle.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <script>
      tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
      });
    </script>
    <?php
     include "includes/navbar.php";
     $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     $idUziv=$_SESSION['idUzivatele'];
     //podminka pro zjisteni, ktera zajisti, ze se pri zadosti zobrazeni kalendare zobrazi opravdu pouze ukolnicek s kalendarem. Duvod - pro zobrazeni ukolu je potreba rozlisovat url od /kalendar a /kalendar?
     if(strpos($celaURL,'kalendar') !== false && strpos($celaURL,'kalendar?ukol') == false)
     {
       echo '
       <div class="kalendarContainer">
         <section class="text-center">
           <div class="row py-lg-5" style="margin-right:0px;">
             <div class="col-lg-6 col-md-8 mx-auto">';
                 include "includes/errorVypis.php";
               echo '
               <h1 class="fw-light">Kalendář úkolů</h1>';
                 if($_SESSION['poziceUzivatele'] == "Skladník" || $_SESSION['poziceUzivatele'] == "Montér")
                 {
                   echo '<p class="lead text-muted">
                     V této sekci naleznete výpis všech aktuálních úkolů, které Vám byli zadány k vypracování.
                     Zadavatelem těchto úkolu je vždy Váš nadřízený, jehož jméno se zobrazuje u každého úkolu.
                   </p>';
                 }
                 else if($_SESSION['poziceUzivatele'] == "nezadáno")
                 {
                    echo '<p class="lead text-muted">
                     Tato sekce není prozatím dostupná! Váš nadřízený Vám musí nejprve nastavit roli!
                   </p>';   
                 }
                 else if($_SESSION['poziceUzivatele'] == "Šéf" || $_SESSION['poziceUzivatele'] == "Administrátor")
                 {
                   echo '<p class="lead text-muted">
                     V této sekci naleznete výpis všech aktuálních úkolů, které byli zadány k vypracování. Na této stránce máte možnost vytvořit nový úkol, smazat úkol, upravit jej a nebo si jej také zobrazit a třeba pročíst.
                   </p>';
                 }
                 echo '
             </div>
           </div>
         </section>';
         if($_SESSION['poziceUzivatele'] == "Skladník" || $_SESSION['poziceUzivatele'] == "Montér")
         {
           echo '
           <div class="col-md-10 col-md-offset-1 mx-auto" style="margin-bottom:40px;">
    
                   <div class="panel panel-default panel-table">
                     <div class="panel-heading">
                       <div class="row" style="padding:8px 8px 0px 8px;">
                         <div class="col col-xs-6">
                           <h3 class="panel-title">Výpis všech úkolů</h3>
                         </div>
                       </div>
                     </div>
                     <div class="panel-body table-responsive">
                       <table class="table table-striped table-bordered table-list">
                         <thead>
                           <tr style="text-align: center;">
                               <th>ID</th>
                               <th>Název úkolu</th>
                               <th>Zadal</th>
                               <th>Vykonává</th>
                               <th>Datum zadání</th>
                               <th>Stav úkolu</th>
                               <th>Od</th>
                               <th>Do</th>
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                         $cisloStrana = substr($celaURL, strrpos($celaURL, 'r')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                         $pomStrana=0;
                         $idUziv = $_SESSION['idUzivatele'];
                         if($cisloStrana == 1)
                    		$pomStrana = 0;
                    	 else if($cisloStrana > 1)
                    		$pomStrana = 10*$cisloStrana-10;
                    	 else
                    		$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku
                            
                         $sql = "SELECT *  FROM `ukoly` WHERE zadany_monter_id=$idUziv ORDER BY id DESC LIMIT 10 OFFSET $pomStrana;";
                         $vys= mysqli_query($pripojeni,$sql);
                         $pocetUkolu=mysqli_num_rows($vys);
    
                         if($pocetUkolu > 0){
                           while($row = mysqli_fetch_assoc($vys))
                           {
                             $pomIdZad=$row['zadal_id'];
                             $sqlu = "SELECT * FROM `uzivatele` WHERE id=$pomIdZad"; 	//limit - max int
                             $vysu= mysqli_query($pripojeni,$sqlu);
                             $rowu= mysqli_fetch_assoc($vysu);
                             
                             $sqla = "SELECT * FROM `uzivatele` WHERE id=$idUziv"; 	//limit - max int
                             $vysa= mysqli_query($pripojeni,$sqla);
                             $rowa= mysqli_fetch_assoc($vysa);
                            
                             $datum = strtotime($row['datum']);
    
                             echo '
                                 <tr style="vertical-align: middle;text-align: center;">
                                   <td>'.$row['id'].'</td>
                                   <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>
                                   <td>'.$rowu['jmeno']." ".$rowu['prijmeni'].'</td>
                                   <td>'.$rowa['jmeno']." ".$rowa['prijmeni'].'</td>
                                   <td>'.date('d.m.Y', $datum).'</td>';
                                   if($row['stav'] == "probihajici")
                                     echo '<td style="color:orange;font-weight: bold;">PROBÍHAJÍCÍ</td>';
                                   else if($row['stav'] == "hotove")
                                     echo '<td style="color:green;font-weight: bold;">HOTOVÉ</td>';
                                   else if($row['stav'] == "nesplnene")
                                     echo '<td style="color:red;font-weight: bold;">NESPLNĚNÉ</td>';
                                    echo '<td>'.$row['odkdy'].'</td>
                                          <td>'.$row['dokdy'].'</td>';
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
                             <a class="page-link" href="kalendar?str'.($cisloStrana-1).'">Předchozí</a>
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
                        $sqlu = "SELECT * FROM ukoly";
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
     						echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str1">1</a></li>';
                        else if($cisloStrana == "")
                            echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str1">1</a></li>';
                        else
                            echo '<li class="page-item"><a class="page-link" href="kalendar?str1">1</a></li>';
    
        				for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                          if($cisloStrana == $i)
     						echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str'.$i.'">'.$i.'</a></li>';
                          else
                            echo '<li class="page-item"><a class="page-link" href="kalendar?str'.$i.'">'.$i.'</a></li>';
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
                                  <a class="page-link" href="?str2">Další</a>
                                </li>';
                        }
                        else {
                          echo '<li class="page-item">
                                  <a class="page-link" href="kalendar?str'.($cisloStrana+1).'">Další</a>
                                </li>';
                        }
                         echo '
                         </ul>
                       </nav>
                       </div>
                     </div>
                   </div>';
             
           echo '</div>';
         }
         else if($_SESSION['poziceUzivatele'] == "Šéf" || $_SESSION['poziceUzivatele'] == "Administrátor")
         {
           echo '
           <div class="col-md-10 col-md-offset-1 mx-auto" style="margin-bottom:40px;">

               <div class="panel panel-default panel-table">
                 <div class="panel-heading">
                   <div class="row" style="padding:8px 8px 0px 8px;">
                     <div class="col col-xs-6">
                       <h3 class="panel-title">Výpis všech úkolů</h3>
                     </div>
                     <div class="col col-xs-6">
                       <a href="novyukol" class="btn btn-sm btn-primary btn-create">Vytvořit nový úkol</a>
                     </div>
                   </div>
                 </div>
                 <div class="panel-body table-responsive">
                   <table class="table table-striped table-bordered table-list">
                     <thead>
                       <tr style="text-align: center;">
                           <th></th>
                           <th></th>
                           <th>ID</th>
                           <th>Název úkolu</th>
                           <th>Zadal</th>
                           <th>Vykonává</th>
                           <th>Datum zadání</th>
                           <th>Stav úkolu</th>
                           <th>Od</th>
                           <th>Do</th>
                       </tr>
                     </thead>
                     <tbody id="myTable">';
                     //-------------------------------------------Výpis do tabulky pro roli šéf,admin---------------------------------------------------------------
                     $cisloStrana = substr($celaURL, strrpos($celaURL, 'r')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                     $pomStrana=0;
                     if($cisloStrana == 1)
                				$pomStrana = 0;
                		 else if($cisloStrana > 1)
                				$pomStrana = 10*$cisloStrana-10;
                		 else
                				$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku


                     $sql = "SELECT *  FROM `ukoly` ORDER BY id DESC LIMIT 10 OFFSET $pomStrana;";
                     $vys= mysqli_query($pripojeni,$sql);
                     $pocetUkolu=mysqli_num_rows($vys);

                     if($pocetUkolu > 0){
                       while($row = mysqli_fetch_assoc($vys))
                       {
                         $pom=$row['zadany_monter_id'];
                         $pomDva=$row['zadal_id'];
                         $pomTri=$row['id'];
                         $sqli = "SELECT * FROM `uzivatele` WHERE id=$pomDva"; 	//limit - max int
                         $vysi= mysqli_query($pripojeni,$sqli);
                         $rowi= mysqli_fetch_assoc($vysi);

                         $sqla = "SELECT * FROM `uzivatele` WHERE id=$pom"; 	//limit - max int
                         $vysa= mysqli_query($pripojeni,$sqla);
                         $rowa= mysqli_fetch_assoc($vysa);
                         
                         $sqle = "SELECT * FROM `objednavkySklad` WHERE idUkolu=$pomTri"; 	//limit - max int
                         $vyse= mysqli_query($pripojeni,$sqle);
                         $pocetObjednaveke=mysqli_num_rows($vyse);

                         $datum = strtotime($row['datum']);

                         echo '
                             <tr style="vertical-align: middle;text-align: center;">
                               <td>
                                <form method="post" action="editukol?ukol'.$row['id'].'">
                                 <button type="submit" name="editUkol" class="btn btn-secondary"><em class="fa fa-pencil"></em></button>
                                </form>
                               </td>
                               <td>
                               ';
                               //nelze mazat ukoly pokud uz pro ne vznikla objednavka a nebo pokud maji jiny stav nez probihajici
                               if($pocetObjednaveke==0 && $row['stav']=="probihajici" || $_SESSION['poziceUzivatele'] == "Administrátor"){
                                   echo '
                                   <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter'.$row['id'].'">
                                     <em class="fa fa-trash"></em>
                                   </button>
                                   <!-- Modal -->
                                   <div class="modal fade" id="exampleModalCenter'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content">
                                         <div class="modal-header">
                                           <h5 class="modal-title" id="exampleModalLongTitle">Odstranit úkol</h5>
                                         </div>
                                         <div class="modal-body" style="text-align: left;">
                                           Jste si jistí, že opravdu chcete odstranit tento úkol? Vaše změny nebudou možné vrátit zpět!
                                         </div>
                                         <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                           <form style="float:left;margin-left:5px;" method="POST" action="../scripts/smazatUkol">
                                             <input type="hidden" name="idUkoluHidden" value="'.$row['id'].'">
                                             <button type="submit" name="smazatUkol" class="btn btn-danger">Odstranit</button>
                                           </form>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                   </td>';
                               }
                               else
                               {
                                   echo '
                                   <button type="button" class="btn btn-dark disabled">
                                     <em class="fa fa-trash"></em>
                                   </button>';
                               }
                               echo '
                               <td>'.$row['id'].'</td>
                               <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>';
                               if($rowi['id'] == $row['zadal_id'])
                                 echo '<td>'.$rowi['jmeno']." ".$rowi['prijmeni'].'</td>';
                               if($rowa['id'] == $row['zadany_monter_id'])
                                 echo '<td>'.$rowa['jmeno']." ".$rowa['prijmeni'].'</td>';
                               echo '<td>'.date('d.m.Y', $datum).'</td>';
                               if($row['stav'] == "probihajici")
                                 echo '<td style="color:orange;font-weight: bold;">PROBÍHAJÍCÍ</td>';
                               else if($row['stav'] == "hotove")
                                 echo '<td style="color:green;font-weight: bold;">HOTOVÉ</td>';
                               else if($row['stav'] == "nesplnene")
                                 echo '<td style="color:red;font-weight: bold;">NESPLNĚNÉ</td>';
                                echo '<td>'.$row['odkdy'].'</td>
                                      <td>'.$row['dokdy'].'</td>';
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
                         <a class="page-link" href="kalendar?str'.($cisloStrana-1).'">Předchozí</a>
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
                    $sqlu = "SELECT * FROM ukoly";
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
 						echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str1">1</a></li>';
                    else if($cisloStrana == "")
                        echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str1">1</a></li>';
                    else
                        echo '<li class="page-item"><a class="page-link" href="kalendar?str1">1</a></li>';

 					for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                      if($cisloStrana == $i)
 						echo '<li class="page-item disabled"><a class="page-link" href="kalendar?str'.$i.'">'.$i.'</a></li>';
                      else{
                         echo '<li class="page-item"><a class="page-link" href="kalendar?str'.$i.'">'.$i.'</a></li>';
                      }
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
                              <a class="page-link" href="?str2">Další</a>
                            </li>';
                    }
                    else {
                      echo '<li class="page-item">
                              <a class="page-link" href="kalendar?str'.($cisloStrana+1).'">Další</a>
                            </li>';
                    }
                     echo '
                     </ul>
                   </nav>
                   </div>
                 </div>
               </div>';
         }
       echo '</div>';
     }
     else {
       //------------------------------VYPIS UKOLU NA CISTOU STRANKU, CISTA STRANKA ZAJISTENA POMOCI PODMINEK NA ODKAZY------------------------------
       $idUkolu = substr($celaURL, strrpos($celaURL, 'l')+1);
       $sql = "SELECT *  FROM `ukoly` WHERE id=$idUkolu;"; 	//limit - max int
       $vys= mysqli_query($pripojeni,$sql);
       $row = mysqli_fetch_assoc($vys);
       $pocetUkolu=mysqli_num_rows($vys);

       if($pocetUkolu > 0){     //V pripade, ze by doslo k neopravnenemu pristupu pres odkaz k ukolu, ktery neni nas a neexistuje, osetrujeme PHP error
         if($idUziv == $row['zadany_monter_id'] || $_SESSION['poziceUzivatele'] == "Šéf" || $_SESSION['poziceUzivatele'] == "Administrátor")  //kontrola zdali ukol, ke kteremu pristupujeme pres url byl pripsan uzivateli jenz je prihlasen.
         {
           $idcko=$row['zadal_id'];
           $sqli = "SELECT * FROM `uzivatele` WHERE id=$idcko;";
           $vysi= mysqli_query($pripojeni,$sqli);
           $rowi = mysqli_fetch_assoc($vysi);
           $datum = strtotime($row['datum']);
            echo '
            <div class="kalendarContainer">';
                include "includes/errorVypis.php";
                echo '
                <div class="row py-lg-5" style="margin-right:0px;">
                  <div class="col-md-10 mx-auto">
                  <div class="card-header">
                    <div class="ustify-content-between align-items-center">
                        <div class="ml-2">
                          <div class="leva">
                            <h4>Název: '.$row['nazev'].'</h4>
                            <p>Zadal/a: '.$rowi['jmeno'].' '.$rowi['prijmeni'].', dne '.date('d.m.Y', $datum).'</p>
                          </div>
                          <div class="prava">
                            <p>Stav úkolu: ';
                            if($row['stav']=="probihajici")
                              echo 'PROBÍHAJÍCÍ';
                            else if($row['stav'] == "hotove")
                              echo 'SPLNĚNO';
                            else {
                                echo 'NESPLNĚNO';
                            }
                            echo '</p>
                            <p>Úkol je nutné vyřešit od: '.$row['odkdy'].' do: '.$row['dokdy'].'</p>
                        </div>
                        </div>
                    ';
                  echo '</div>
                  </div>
                  <div class="card-body" style="margin-top: 5px;margin-left:5px;margin-right:5px;word-break: break-all;">
                    <h5>Adresa zákazníka</h5>
                    Město: '.$row['mesto'].'<br>
                    Ulice: '.$row['ulice'].'<br>
                    Č.p.: '.$row['cp'].'<br>
                    PSČ: '.$row['psc'].'<br><br>
                    '.$row['textUlohy'].'
                  </div>
                  <div class="card-footer">';
                    if($row['stav']=="probihajici"){
                        echo '<a href="#textAreaKoment" onclick="javascript:zobrazTextPole();" class="btn btn-link" style="color:black;"><i class="far fa-comment" style="margin-right:5px;color:black;"></i> Přidat záznam do deníku</a>';
                    }
                    else
                    {
                        echo '<button class="btn btn-link disabled" style="color:black;"><i class="far fa-comment" style="margin-right:5px;color:black;"></i> Přidat záznam do deníku</button>';
                    }
                    if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Administrátor")
                    {
                        echo '
                        <button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#exampleModal">
                          Nastavit stav úkolu
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Změnit stav úlohy</h5>
                                <button type="button" class="btn btn-link" style="color:black;" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                              </div>
                              <div class="modal-body">
                                Pokud chcete změnit stav úlohy klikněte jedno z tlačítek níže, které odpovídá stavu, který chcete nastavit.<br><br><b>Změny lze provést kdykoliv.</b>
                              </div>
                              <div class="modal-footer">
                                <form action="../scripts/stavUkolu" method="POST">
                                    <input type="hidden" name="idUkoluHidden" value="'.$idUkolu.'">
                                    <button type="submit" name="ukolHotov" class="btn btn-success">Hotový <i class="fa-solid fa-circle-check"></i></button>
                                </form>
                                <form action="../scripts/stavUkolu" method="POST">
                                    <input type="hidden" name="idUkoluHidden" value="'.$idUkolu.'">
                                    <button type="submit" name="ukolProbi" class="btn btn-warning">Probíhající <i class="fa-solid fa-spinner"></i></button>
                                </form>
                                <form action="../scripts/stavUkolu" method="POST">
                                    <input type="hidden" name="idUkoluHidden" value="'.$idUkolu.'">
                                    <button type="submit" name="ukolNedoko" class="btn btn-danger">Nedokončený <i class="fa-solid fa-xmark"></i></button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>';
                    }
                    echo'
                  </div>
                  <div class="poznamkySekce">
                    <h5>Poznámky deníku</h5>
                    <hr>
                    <div class="col-md-10 mx-auto" id="komentForum" style="margin-left:5%; margin-bottom: 20px;">
    					<div class="media comment-box" style="margin-top: 20px;">
    					  <div class="media-left">';
                          $sqlZaznam = "SELECT * FROM ukolykomentare WHERE id_ukolu='$idUkolu' ORDER BY id;";
    				      $vysZaznam = mysqli_query($pripojeni,$sqlZaznam);
                          if(mysqli_num_rows($vysZaznam)>0){	//pokud sql tabulka neco obsahuje tak se if provede
    					    while($rowKom = mysqli_fetch_assoc($vysZaznam)){
    					      $idkomUz=$rowKom['id_uzivatele'];
    					      $sqle = "SELECT * FROM `uzivatele` WHERE id=$idkomUz;";
                              $vyse= mysqli_query($pripojeni,$sqle);
                              $rowe = mysqli_fetch_assoc($vyse);
                              $datumV = strtotime($rowKom['datumZapisu']);
                              
                              $filename="../photos/profile/profile".$idkomUz."*";
                              $fileinfo=glob($filename);
                              $fileext=explode(".",$fileinfo[0]);
          					  echo '</div>
          										<div class="media-body" style="word-break: break-all;">';
                                    //**********************************************************************************************VYPIS ZAZNAMU*****************************************************************
          												  if(isset($_SESSION['idUzivatele']) && $_SESSION['idUzivatele']==$rowKom['id_uzivatele'] || ($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Administrátor")){
                                                            if($rowe['profilovka'] == 1){
                											echo '<h6 class="media-heading"><img src="../../photos/profile/profile'.$idkomUz.'.'.$fileext[3].'" style="width:40px!important;height:40px!important;margin-right: 10px;" class="rounded-circle me-2" alt="Profilová fotka">';

                											}else{
                											echo '<h6 class="media-heading"><img src="../../photos/profile/default.jpg" style="width:40px!important;height:40px!important;margin-right: 10px;" class="rounded-circle me-2" alt="Profilová fotka">';
                											}
          														echo ''.$rowe['jmeno'].' '.$rowe['prijmeni'].' - '.$rowe['pozice'].', dne '.date('d.m.Y', $datumV).'</h6>';
          														    if($row['stav']=="probihajici"){
          														        echo '
          																<div class="dropdown" style="float:right;margin-top:-50px;">
          																	<button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          																	</button>
          																	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">';
          																		echo	'<form action="../scripts/odstranitZaznamDenik.php" method="post" style="margin-bottom:5px;">
          																						 <button class="dropdown-item" type="submit" name="odstranitZaznam" style="margin-right:5px;outline:none;border:0;">
          																							<i class="fas fa-trash-alt"></i>
          																							Odstranit záznam
          																						 </button>
                                                                                                 <input type="hidden" name="idUkolu" value="'.$rowKom['id_ukolu'].'">
          																						 <input type="hidden" name="zaznamid" value="'.$rowKom['id'].'">
          																				 </form>';
          																		echo	'<form action="#textAreaKoment" method="post" style="margin-bottom:5px;">
          																					<button class="dropdown-item" type="submit" name="upravitKomentar" style="margin-right:5px;outline:none;border:0;">
          																						<i class="fas fa-edit"></i>
          																						Upravit záznam
          																					</button>
          																					<input type="hidden" name="idZaznamu" value="'.$rowKom['id'].'">
          																				</form>';
          															echo '</div>
          																</div>';
          														    }
          														    echo '
          															</h4>';
          													}
          											echo '<div style="background-color:white;border: 1px solid #ddd;padding: 10px;">'.$rowKom['textZaznamu'].'</div>';
          										echo '
          									<hr>
                            ';
                            //**********************************************************************************************************************************************************************
                          }
                      }
                      if(isset($_SESSION['idUzivatele']) && $row['stav'] == "probihajici"){
              					echo '<div id="textovePole">';
              					echo '<p style="font-size:18px;"><strong>Vložit záznam do deníku</strong></p>';
              					if(!isset($_POST['upravitKomentar'])){
              					echo '<form id="textAreaKoment" method="post" action="../scripts/pridejZaznamDenik.php">
              						    <textarea name="textZaznamu" style=" float:left;">
              							</textarea>
                                        <input type="hidden" name="ukolid" value="'.$idUkolu.'">
              							<button name="submitZaznam" class="btn btn-primary" type="submit" style="margin-top:10px;float:left;clear:left;margin-bottom:50px;">Přidat záznam</button>
              						  </form>';
              					}
              					else{
              					$idDotZaz=$_POST['idZaznamu'];
              					$sqlDotZaz="SELECT * FROM ukolykomentare WHERE id=$idDotZaz;";
              					$vysDotZaz=mysqli_query($pripojeni,$sqlDotZaz);
              					$rowDotZaz=mysqli_fetch_assoc($vysDotZaz);
              					echo '<form id="textAreaKoment" method="post" action="../scripts/upravitZaznamDenik.php">
                                            <textarea name="textZaznamu" style=" float:left;">
                                            '.$rowDotZaz['textZaznamu'].'
                                            </textarea>
                                            <input type="hidden" name="ukolid" value="'.$idUkolu.'">
                                            <input type="hidden" name="zaznamid" value="'.$idDotZaz.'">
                  							<button name="sumbitUprava" class="btn btn-primary" type="submit" style="margin-top:10px;float:left;clear:left;margin-bottom:50px;">Upravit záznam</button>
              						  </form>';
              					}
                        echo '</div>';
                    echo '
              							</div>
                           </div>
                          </div>
                         </div>
                        </div>
                        ';
          }
      }
      else {
        // Error vypis pro neopravneny pristup
        echo '
        <div class="kalendarContainer">
          <section class="text-center">
            <div class="row py-lg-5" style="margin-right:0px;">
              <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Error</h1>
                <p>
                 Vraťte se zpět na úvodní stránku!
                </p>
              </div>
            </div>
          </section></div>';
      }
    }
     else {
       // Error vypis pro pristup k neexistujicim zaznamum
       echo '
       <div class="kalendarContainer">
         <section class="text-center">
           <div class="row py-lg-5" style="margin-right:0px;">
             <div class="col-lg-6 col-md-8 mx-auto">
               <h1 class="fw-light">Error</h1>
               <p>
                Vraťte se zpět na úvodní stránku!
               </p>
             </div>
           </div>
         </section></div>';
     }
    }
    ?>

</body>
</html>
