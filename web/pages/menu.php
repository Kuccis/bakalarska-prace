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
    <link rel="stylesheet" href="../css/adminPanelCss.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
    if($_SESSION['poziceUzivatele'] != "Administrátor"){
        header("Location: ../pages/uvod");
        exit();
    }
    else{
     include "includes/navbar.php";
     
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">
             <h1 class="display-5 fw-light">Řídící panel</h1>
             <div class="col-lg-6 mx-auto">
               <p class="lead mb-4 text-muted">Tento panel slouží k přehlednému zobrazení veškerých dat pro administrátory.</p>
             </div>
         ';
         include "includes/adminPanel.php";
         include "includes/errorVypis.php";
       $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       if(strpos($celaURL,'ukoly') !== false){
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

                     $sql = "SELECT *  FROM `ukoly` ORDER BY id DESC";
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
                                             <button type="submit" name="smazatUkolMenu" class="btn btn-danger">Odstranit</button>
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
                               <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="kalendar?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$row['nazev'].'</a></td>';
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
                 </div>';
       }
       else if(strpos($celaURL,'helpdesk') !== false){
           
       }
       else if(strpos($celaURL,'objednavky') !== false){
        echo '
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
                               <th></th>
                               <th></th>
                               <th>ID</th>
                               <th>Název úkolu</th>
                               <th>Objednal</th>
                               <th>Datum objednávky</th>
                               <th>Stav objednávky</th>
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                   
                         $sql = "SELECT * FROM `objednavkySklad` ORDER BY id DESC";
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
                                 <td>';
                                 if($row['stav'] == 0 || $row['stav'] == 2){
                                    echo'
                                    <button class="btn btn-dark disabled">
                                     Vydat věci
                                   </button>';
                                 }
                                 else if($row['stav'] == 1 || $row['stav'] == 3){
                                   echo'
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenterz'.$row['id'].'">
                                     Vydat věci
                                   </button>
                                   <!-- Modal -->
                                   <div class="modal fade" id="exampleModalCenterz'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content">
                                         <div class="modal-header">
                                           <h5 class="modal-title" id="exampleModalLongTitle">Vydat věci pro úkol</h5>
                                         </div>
                                         <div class="modal-body" style="text-align: left;">
                                           Jste si jistí, že opravdu chcete potvrdit vydání věcí? Před potvrzením tohoto okna se ujistěte, že jste pracovníkovi předal vše objednané.<br><br>Vaše akce nebudou možné vrátit zpět!
                                         </div>
                                         <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                           <form style="float:left;margin-left:5px;" method="POST" action="../scripts/objednavkascr">
                                             <input type="hidden" name="idObjednavkyHidden" value="'.$row['id'].'">
                                             <button type="submit" name="vydatVeci" class="btn btn-success">Schválit vydání</button>
                                           </form>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                   ';
                                 }
                                 else if($row['stav'] == 4 || $row['stav'] == 6 && $rowi['stav']=="hotove" || $rowi['stav']=="nesplnene")
                                 {
                                    echo '
                                    <form action="vratitNaSklad" method="POST">
                                        <input type="hidden" name="idObjednavkyHidden" value="'.$row['id'].'">
                                        <input type="hidden" name="idUkoluHidden" value="'.$row['idUkolu'].'">
                                        <button type="submit" class="btn btn-dark">Vrátit věci</button>
                                    </form>';
                                 }
                                 else if($row['stav'] == 5)
                                 {
                                    echo '
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="U objednávky už vrácení věcí proběhlo.">
                                        <button class="btn btn-dark disabled">Vrátit věci</button>
                                    </span>';
                                 }
                                 echo '
                                   </td>
                                   <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCentero'.$row['id'].'">
                                     Smazat objednávku
                                   </button>
                                   <!-- Modal -->
                                   <div class="modal fade" id="exampleModalCentero'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content">
                                         <div class="modal-header">
                                           <h5 class="modal-title" id="exampleModalLongTitle">Smazat objednávku</h5>
                                         </div>
                                         <div class="modal-body" style="text-align: left;">
                                           Jste si jistí, že opravdu chcete potvrdit smazání objednávky? Před potvrzením tohoto okna se ujistěte, že šéf Javosoftware s vašim rozhodnutím souhlasí!<br><br>Vaše akce nebudou možné vrátit zpět!
                                         </div>
                                         <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                           <form style="float:left;margin-left:5px;" method="POST" action="../scripts/objednavkascr">
                                             <input type="hidden" name="idObjednavkyHidden" value="'.$row['id'].'">
                                             <button type="submit" name="smazatObj" class="btn btn-danger">Smazat objednávku</button>
                                           </form>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                   
                                   </td>
                                   <td>'.$row['id'].'</td>
                                   <td style="font-weight: bold;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 227px;"><a href="objednavky?ukol'.$row['id'].'" style="font-weight: bold;text-decoration: none;">'.$rowi['nazev'].'</a></td>';
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
                     </div>';   
       }
       else{
           echo '
           <div class="col-md-10 col-md-offset-1 mx-auto" style="margin-bottom:40px;">
                       <div class="panel panel-default panel-table">
                         <div class="panel-heading">
                           <div class="row" style="padding:8px 8px 0px 8px;">
                             <div class="col col-xs-6">
                               <h3 class="panel-title">Výpis všech uživatelů</h3>
                             </div>
                           </div>
                         </div>
                         <div class="panel-body table-responsive">
                           <table class="table table-striped table-bordered table-list">
                             <thead>
                               <tr style="text-align: center;">
                                   <th>ID</th>
                                   <th>Jméno a příjmení</th>
                                   <th>Tel. č.</th>
                                   <th>E-mail</th>
                                   <th>Role/pozice</th>
                                   <th>BAN stav</th>
                                   <th>Profil. fotografie</th>
                               </tr>
                             </thead>
                             <tbody id="myTable">';
                             $sql = 'SELECT *  FROM `uzivatele`';
                             $vys= mysqli_query($pripojeni,$sql);
                             $pocetUziv=mysqli_num_rows($vys);
        
                             if($pocetUziv > 0){
                               while($row = mysqli_fetch_assoc($vys))
                               {
                                     echo '
                                         <tr style="vertical-align: middle;text-align: center;">
                                           <td>'.$row['id'].'</td>
                                           <td><a href="role?uzivatel'.$row['id'].'" style="text-decoration: none;font-weight:bold;">'.$row['jmeno'].' '.$row['prijmeni'].'</a></td>
                                           <td>'.$row['telcis'].'</td>
                                           <td>'.$row['email'].'</td>
                                           <td>'.$row['pozice'].'</td>';
                                           if($row['ban'] == 0)
                                             echo '<td style="color:green;font-weight: bold;">NEZABANOVÁN</td>';
                                           else
                                             echo '<td style="color:red;font-weight: bold;">ZABANOVÁN</td>';
                                           if($row['profilovka'] == 0)
                                             echo '<td><img src="../photos/profile/default.jpg" id="profilFotoNastaveni" width="50" height="50" alt="Profilová fotka"></td>';
                                           else{
                                            $sessionid=$row['id'];
                                            $filename="../photos/profile/profile".$sessionid."*";
                                            $fileinfo=glob($filename);
                                            $fileext=explode(".",$fileinfo[0]);
          						            echo '<td><img src="../photos/profile/profile'.$sessionid.'.'.$fileext[3].'" id="profilFotoNastaveni" width="50" height="50" alt="Profilová fotka"></td>';
                                           }
                                     echo  '</tr>';
                               }
                           }
                           else {
                             echo '
                                 <tr>
                                   <td colspan="10">
                                     Žádný uživatel nebyl nalezen
                                   </td>
                                 </tr>';
                           }
                             echo   '</tbody>
                           </table>
                         </div>
                         </div>
                       </div>';
                 
               echo '</div>';
       }
    }
    ?>
</body>
</html>
