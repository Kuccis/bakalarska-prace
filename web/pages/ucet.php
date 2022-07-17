<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/ucetStyle.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     include "includes/navbar.php";
     echo '
    
     <div class="ucetContainer">';
     $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     $idUziv=$_SESSION['idUzivatele'];
     if(strpos($celaURL,'ucet') !== false && strpos($celaURL,'ucet?ukol') == false)
     {
       echo '
         <section class="text-center">
           <div class="row py-lg-5" style="margin-right:0px;">
             <div class="col-lg-6 col-md-8 mx-auto">';
              include "includes/errorVypis.php";
              echo'
               <h1 class="fw-light">Vyúčtování</h1>';
                 if($_SESSION['poziceUzivatele'] == "nezadáno"){
                     echo '<p class="lead text-muted">
                     Tato sekce není prozatím dostupná! Váš nadřízený Vám musí nejprve nastavit roli!
                   </p>';
                 }
                 else
                 {
                    echo '
                     <p class="lead text-muted">
                         V této sekci naleznete výpis všech hotových úkolů, ke kterým máte možnost vytvořit účtenku.
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
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                         $cisloStrana = substr($celaURL, strrpos($celaURL, 't')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                         $pomStrana=0;
                         $idUziv = $_SESSION['idUzivatele'];
                         if($cisloStrana == 1)
                    				$pomStrana = 0;
                    		 else if($cisloStrana > 1)
                    				$pomStrana = 10*$cisloStrana-10;
                    		 else
                    				$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku
                         $sql = 'SELECT *  FROM `ukoly` WHERE stav="hotove" AND zadany_monter_id='.$idUziv.' ORDER BY id DESC LIMIT 10 OFFSET '.$pomStrana.';';
                         $vys= mysqli_query($pripojeni,$sql);
                         $pocetUkolu=mysqli_num_rows($vys);
    
                         if($pocetUkolu > 0){
                           while($row = mysqli_fetch_assoc($vys))
                           {
                             $pomIdZad=$row['zadal_id'];
                             $idUkolu=$row['id'];
                             $sqlu = "SELECT * FROM `uzivatele` WHERE id=$pomIdZad"; 
                             $vysu= mysqli_query($pripojeni,$sqlu);
                             $rowu= mysqli_fetch_assoc($vysu);
                             
                             $sqlUc = "SELECT * FROM `uctenky` WHERE idUkolu=$idUkolu"; 
                             $vysUc= mysqli_query($pripojeni,$sqlUc);
                             $rowUc= mysqli_fetch_assoc($vysUc);
                             $pocetUctenek=mysqli_num_rows($vysUc);
                            
                             $datum = strtotime($row['datum']);
                             if($pocetUctenek == 0){
                                 echo '
                                     <tr style="vertical-align: middle;text-align: center;">
                                       <td>'.$row['id'].'</td>
                                       <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>
                                       <td>'.$rowu['jmeno']." ".$rowu['prijmeni'].'</td>
                                       <td>'.$_SESSION['jmenoUzivatele']." ".$_SESSION['prijmeniUzivatele'].'</td>
                                       <td>'.date('d.m.Y', $datum).'</td>';
                                       if($row['stav'] == "hotove")
                                         echo '<td style="color:orange;font-weight: bold;">LZE ZAÚČTOVAT</td>';
                                 echo  '</tr>';
                             }
                             else{
                                echo '
                                     <tr style="vertical-align: middle;text-align: center;">
                                       <td>'.$row['id'].'</td>
                                       <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>
                                       <td>'.$rowu['jmeno']." ".$rowu['prijmeni'].'</td>
                                       <td>'.$_SESSION['jmenoUzivatele']." ".$_SESSION['prijmeniUzivatele'].'</td>
                                       <td>'.date('d.m.Y', $datum).'</td>';
                                       if($row['stav'] == "hotove")
                                         echo '<td style="color:green;font-weight: bold;">JIŽ ZAÚČTOVÁNO</td>';
                                 echo  '</tr>'; 
                             }
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
                             <a class="page-link" href="ucet?st'.($cisloStrana-1).'">Předchozí</a>
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
                        $sqlu = "SELECT * FROM ukoly WHERE stav=hotove";
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
     						echo '<li class="page-item disabled"><a class="page-link" href="ucet?st">1</a></li>';
                        else if($cisloStrana == "")
                            echo '<li class="page-item disabled"><a class="page-link" href="ucet?st1">1</a></li>';
                        else
                            echo '<li class="page-item"><a class="page-link" href="ucet?st1">1</a></li>';
    
     					for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                          if($cisloStrana == $i)
    						 echo '<li class="page-item disabled"><a class="page-link" href="ucet?st'.$i.'">'.$i.'</a></li>';
                          else
                             echo '<li class="page-item"><a class="page-link" href="ucet?st'.$i.'">'.$i.'</a></li>';
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
                                  <a class="page-link" href="?st2">Další</a>
                                </li>';
                        }
                        else {
                          echo '<li class="page-item">
                                  <a class="page-link" href="ucet?st'.($cisloStrana+1).'">Další</a>
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
     else if($_SESSION['poziceUzivatele'] == "Šéf" || $_SESSION['poziceUzivatele'] == "Administrátor"){
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
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                         //-------------------------------------------Výpis do tabulky pro roli šéf,admin---------------------------------------------------------------
                         $cisloStrana = substr($celaURL, strrpos($celaURL, 't')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                         $pomStrana=0;
                         $idUziv = $_SESSION['idUzivatele'];
                         if($cisloStrana == 1)
                    		$pomStrana = 0;
                    	 else if($cisloStrana > 1)
                    		$pomStrana = 10*$cisloStrana-10;
                    	 else
                    		$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku
                         $sql = 'SELECT *  FROM `ukoly` WHERE stav="hotove" ORDER BY id DESC LIMIT 10 OFFSET '.$pomStrana.';';
                         $vys= mysqli_query($pripojeni,$sql);
                         $pocetUkolu=mysqli_num_rows($vys);
    
                         if($pocetUkolu > 0){
                           while($row = mysqli_fetch_assoc($vys))
                           {
                             $pomIdZad=$row['zadal_id'];
                             $idUkolu=$row['id'];
                             $sqlu = "SELECT * FROM `uzivatele` WHERE id=$pomIdZad"; 
                             $vysu= mysqli_query($pripojeni,$sqlu);
                             $rowu= mysqli_fetch_assoc($vysu);
                             
                             $sqla = "SELECT * FROM `uzivatele` WHERE id=$idUziv"; 
                             $vysa= mysqli_query($pripojeni,$sqla);
                             $rowa= mysqli_fetch_assoc($vysa);
                                
                             $sqlUc = "SELECT * FROM `uctenky` WHERE idUkolu=$idUkolu"; 
                             $vysUc= mysqli_query($pripojeni,$sqlUc);
                             $rowUc= mysqli_fetch_assoc($vysUc);
                             $pocetUctenek=mysqli_num_rows($vysUc);
                            
                             $datum = strtotime($row['datum']);
                             if($pocetUctenek == 0){
                                 echo '
                                     <tr style="vertical-align: middle;text-align: center;">
                                       <td>'.$row['id'].'</td>
                                       <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>
                                       <td>'.$rowu['jmeno']." ".$rowu['prijmeni'].'</td>
                                       <td>'.$rowa['jmeno']." ".$rowa['prijmeni'].'</td>
                                       <td>'.date('d.m.Y', $datum).'</td>';
                                       if($row['stav'] == "hotove")
                                         echo '<td style="color:orange;font-weight: bold;">LZE ZAÚČTOVAT</td>';
                                 echo  '</tr>';
                             }
                             else{
                                echo '
                                     <tr style="vertical-align: middle;text-align: center;">
                                       <td>'.$row['id'].'</td>
                                       <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>
                                       <td>'.$rowu['jmeno']." ".$rowu['prijmeni'].'</td>
                                       <td>'.$rowa['jmeno']." ".$rowa['prijmeni'].'</td>
                                       <td>'.date('d.m.Y', $datum).'</td>';
                                       if($row['stav'] == "hotove")
                                         echo '<td style="color:green;font-weight: bold;">JIŽ ZAÚČTOVÁNO</td>';
                                 echo  '</tr>'; 
                             }
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
                             <a class="page-link" href="ucet?st'.($cisloStrana-1).'">Předchozí</a>
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
                        $sqlu = "SELECT * FROM ukoly WHERE stav='hotove'";
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
     						 echo '<li class="page-item disabled"><a class="page-link" href="ucet?st1">1</a></li>';
                        else if($cisloStrana == "")
                             echo '<li class="page-item disabled"><a class="page-link" href="ucet?st1">1</a></li>';
                        else
                             echo '<li class="page-item"><a class="page-link" href="ucet?st1">1</a></li>';
    
     					for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                          if($cisloStrana == $i)
     						 echo '<li class="page-item disabled"><a class="page-link" href="ucet?st'.$i.'">'.$i.'</a></li>';
                          else
                             echo '<li class="page-item"><a class="page-link" href="ucet?st'.$i.'">'.$i.'</a></li>';
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
                                  <a class="page-link" href="?st2">Další</a>
                                </li>';
                        }
                        else {
                          echo '<li class="page-item">
                                  <a class="page-link" href="ucet?st'.($cisloStrana+1).'">Další</a>
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
     }
     if(strpos($celaURL,'ucet?ukol') !== false){
      $idUkolu = substr($celaURL, strrpos($celaURL, 'l')+1);
      $sqlUc = "SELECT * FROM `uctenky` WHERE idUkolu=$idUkolu"; 
      $vysUc= mysqli_query($pripojeni,$sqlUc);
      $rowUc= mysqli_fetch_assoc($vysUc);
      $pocetUctenek=mysqli_num_rows($vysUc);
      echo '
      <div class="container-xl px-4 mt-4">';
            include "includes/errorVypis.php";
        echo'
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active" href="ucet?ukol'.$idUkolu.'">Formulář</a>';
            if($pocetUctenek == 0){
                echo '<a class="nav-link ms-0 disabled">Účtenky</a>';
            }
            else
            {
                echo '<a class="nav-link ms-0" href="uctenka?ukol'.$idUkolu.'">Účtenky</a>';
            }
        echo '
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Billing card 1-->
                <div class="card h-100 border-start-lg border-start-primary">
                    <div class="card-body">
                        <div class="small text-muted">Aktuální cena</div>
                        <div class="h3">';
                            if($pocetUctenek == 0){
                                $pridanyCas=$_POST['odpracovaneHodiny'];
                                $idUkolu= substr($celaURL, strrpos($celaURL, 'l')+1);;
                                $sqlObj = "SELECT * FROM `objednavkySklad` WHERE idUkolu='$idUkolu';";
                                $vysObj = mysqli_query($pripojeni,$sqlObj);
                                while($rowObj = mysqli_fetch_assoc($vysObj)){
                                    $pom=$rowObj['id'];
                                    $sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky='$pom';";
                                    $vysVec = mysqli_query($pripojeni,$sqlVec);
                                    while($rowVec = mysqli_fetch_assoc($vysVec)){
                                        $pomDve=$rowVec['idVeci'];
                                        $sqlVeci = "SELECT * FROM `skladiste` WHERE id='$pomDve';";
                                        $vysVeci = mysqli_query($pripojeni,$sqlVeci);
                                        $rowVeci = mysqli_fetch_assoc($vysVeci);
                                        $cena += $rowVec['pocetVeci'] * $rowVeci['cena'];
                                        
                                    }
                                }
                                //kontrola role uzivatele, dle ktere se nasledne vytahne nastaveny hodinovy poplatek a pripocte se k cene.
                                if($pridanyCas > 0){
                                    $role=$_SESSION['poziceUzivatele'];
                                    if($role == "Šéf")
                                        $sqlPridat = "SELECT * FROM `nastaveniMenu` WHERE nazev='Šéf'";
                                    else if($role == "Montér")
                                        $sqlPridat = "SELECT * FROM `nastaveniMenu` WHERE nazev='Montér'";
                                    else
                                        $sqlPridat = "SELECT * FROM `nastaveniMenu` WHERE nazev='Skladník'";
                                    $vysPridat = mysqli_query($pripojeni,$sqlPridat);
                                    $rowPridat = mysqli_fetch_assoc($vysPridat);
                                    $sazba=$rowPridat['cena'];
                                    $cena += ($pridanyCas * $sazba);
                                }
                                if(isset($cena))
                                    echo $cena." Kč";
                                else
                                    echo "0 Kč";
                            }
                            else{
                                echo $rowUc['cena']." Kč";
                            }
                            echo '
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <!-- Billing card 2-->
                <div class="card h-100 border-start-lg border-start-secondary">
                    <div class="card-body">
                        <div class="small text-muted">Datum vytvoření</div>
                            <div class="h3">
                                '.date('d.m.Y', time()).'
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <!-- Billing card 3-->
                <div class="card h-100 border-start-lg border-start-success">
                    <div class="card-body">
                        <div class="small text-muted">Vytvoření účtenky provedete kliknutím na tlačítko</div>
                        <div class="h3 d-flex align-items-center">
                            ';
                            if($pocetUctenek == 0){
                                echo'
                                <form action="../scripts/vytvorUctenku" method="POST">
                                    <input type="hidden" name="idUkolu" value="'.$idUkolu.'">
                                    <input type="hidden" name="pocetHodin" value="'.$pridanyCas.'">
                                    <input type="hidden" name="cenaUkolu" value="'.$cena.'">
                                    <input type="hidden" name="hodSaz" value="'.$sazba.'">
                                    <button type="submit" name="vytvorUctenku" class="btn btn-primary">Vytvořit účtenku</button>
                                </form>';
                            }
                            else
                            {
                                echo '<button type="submit" class="btn btn-primary disabled">Vytvořit účtenku</button>';
                            }
                            echo '
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        if($pocetUctenek == 0){
        echo '
        <div class="card mb-4">
            <div class="card-header">Formulář</div>
            <div class="card-body p-0">
                <!-- Billing history table-->
                <div class="table-responsive table-billing-history">
                    <include type=text>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="border-gray-200" scope="col">Jméno</th>
                                <th class="border-gray-200" scope="col">Příjmení</th>
                                <th class="border-gray-200" scope="col">Odpracovaný čas (v hodinách)</th>
                                <th class="border-gray-200" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="" method="POST">
                            <tr>
                                <td style="vertical-align:middle;">'.$_SESSION['jmenoUzivatele'].'</td>
                                <td style="vertical-align:middle;">'.$_SESSION['prijmeniUzivatele'].'</td>
                                <td><input type="text" name="odpracovaneHodiny" class="form-control" value="'.$_POST['odpracovaneHodiny'].'"></td>
                                <td style="vertical-align:middle;"><button type="submit" class="btn btn-primary">Přičíst k ceně</button></td>
                            </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
        }
        echo '
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Výpis použitých věcí
            </div>
            <div class="card-body px-0">
                <!-- vypis jednotlivych veci objednanych k ukolu-->
                ';
                $sqlObj = "SELECT * FROM `objednavkySklad` WHERE idUkolu='$idUkolu';";
                $vysObj = mysqli_query($pripojeni,$sqlObj);
                
                $pocetObj=mysqli_num_rows($vysObj);
                if($pocetObj > 0){
                    while($rowObj = mysqli_fetch_assoc($vysObj)){
                        $pom = $rowObj['id'];
                        $sqlVec = "SELECT * FROM `objednavkySklad_veci` WHERE idObjednavky='$pom';";
                        $vysVec = mysqli_query($pripojeni,$sqlVec);
                        while($rowVec = mysqli_fetch_assoc($vysVec)){
                            $pomDve=$rowVec['idVeci'];
                            $sqlVeci = "SELECT * FROM `skladiste` WHERE id='$pomDve';";
                            $vysVeci = mysqli_query($pripojeni,$sqlVeci);
                            $rowVeci = mysqli_fetch_assoc($vysVeci);
                            echo '
                            <div class="d-flex align-items-center justify-content-between px-4">
                                <div class="d-flex align-items-center">';
                                    if($rowVeci['foto']==0){
                                        echo '<img src="../photos/items/defaultItem.jpg" style="width:100px;height:70px;">';
                                    }
                                    else{
                                        $filename="../photos/items/item".$pomDve."*";
                                        $fileinfo=glob($filename);
                                        $fileext=explode(".",$fileinfo[0]);
                                        echo '<img src="../photos/items/item'.$pomDve.'.'.$fileext[3].'" style="width:100px;height:70px;">';
                                    }
                                    echo '
                                    <div class="ms-4">
                                        <div style="font-size:large;">'.$rowVeci['nazev'].'</div>
                                    </div>
                                </div>
                                <div class="ms-4 small">
                                    <input type="text" disabled value="'.$rowVec['pocetVeci'].'" style="text-align:center;" size="6" />
                                </div>
                                
                            </div>
                            <hr>';
                        }
                    }
                }
                else
                {
                    echo '<div class="d-flex align-items-center justify-content-between px-4">K tomuto úkolu nebyla provedena žádná objednávka.</div>';
                }
                echo '
            </div>
        </div>
    
    </div>';
    }
    echo '</div>';

?>
</body>
</html>
