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
    <link rel="stylesheet" href="../css/kalendarStyle.css">
    <link rel="stylesheet" href="../css/nastaveni.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     if($_SESSION['poziceUzivatele'] != "Šéf" && $_SESSION['poziceUzivatele'] != "Administrátor")
     {
         header("Location: ../index");
         exit();
     }
     include "includes/navbar.php";
     if(strpos($celaURL,'role') != false && strpos($celaURL,'role?uzivatel') == false)
     {
           echo '
           <div class="kalendarContainer">
             <section class="text-center">
               <div class="row py-lg-5" style="margin-right:0px;">
                 <div class="col-lg-6 col-md-8 mx-auto">';
                   include "includes/errorVypis.php";
                   echo '
                   <h1 class="fw-light">Výpis všech uživatelů</h1>
                   <p class="lead text-muted">
                      V této sekci najdete kompletní výpis uživatelů. U každého uživatele lze přejít k nastavení, pomocí kterého máte možnost upravit jeho pracovní pozici. Po nastavení pozice se ujistěte, že jste vše nastavil/a správně!
                   </p>
                 </div>
               </div>
             </section>
           
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
                           <tr style="text-align: center;">';
                               echo '
                               <th>ID</th>
                               <th>Jméno a příjmení</th>
                               <th>E-mail</th>
                               <th>Tel. číslo</th>
                               <th>Prac. pozice</th>
                           </tr>
                         </thead>
                         <tbody id="myTable">';
                         //-------------------------------------------Výpis do tabulky pro roli šéf,admin---------------------------------------------------------------
                         $cisloStrana = substr($celaURL, strrpos($celaURL, 'a')+1);  //vezme celou URL, najde posledni R a vezme cislo za nim. Diky tomu mohu zjisit posun 1,2,3,...
                         $pomStrana=0;
                         if($cisloStrana == 1)
                    	    $pomStrana = 0;
                    	 else if($cisloStrana > 1)
                    		$pomStrana = 10*$cisloStrana-10;
                    	 else
                    		$pomStrana = 0; //POKUD je adresa defaultni (bez cisla stranek) tak se zobrazi prvnich 10 prispevku
                           $sqla = "SELECT * FROM `uzivatele`"; 	//limit - max int
                           $vysa= mysqli_query($pripojeni,$sqla);
                           while($row = mysqli_fetch_assoc($vysa))
                           {
                             echo '
                                 <tr style="vertical-align: middle;text-align: center;">
                                   <td>'.$row['id'].'</td>
                                   <td><a href="role?uzivatel'.$row['id'].'" style="text-decoration: none;font-weight:bold;">'.$row['jmeno'].' '.$row['prijmeni'].'</a></td>
                                   <td>'.$row['email'].'</td>
                                   <td>'.$row['telcis'].'</td>';
                                   if($row['pozice'] != "nezadáno")
                                    echo '<td style="color:green;font-weight: bold;">'.$row['pozice'].'</td>';
                                   else{
                                    echo '<td style="color:red;font-weight: bold;">Nezadáno</td>';   
                                   }
                                echo '
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
                             <a class="page-link" href="role?str'.($cisloStrana-1).'">Předchozí</a>
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
                        $sqlu = "SELECT * FROM uzivatele";
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
     						echo '<li class="page-item disabled"><a class="page-link" href="role?str1">1</a></li>';
                        else if($cisloStrana == "")
                             echo '<li class="page-item disabled"><a class="page-link" href="role?str1">1</a></li>';
                        else
                             echo '<li class="page-item"><a class="page-link" href="role?str1">1</a></li>';
    
     					for ($i = 2; $i <= $_SESSION['pocetStran']; $i++) {
                          if($cisloStrana == $i)
     						 echo '<li class="page-item disabled"><a class="page-link" href="role?str'.$i.'">'.$i.'</a></li>';
                          else
                             echo '<li class="page-item"><a class="page-link" href="role?str'.$i.'">'.$i.'</a></li>';
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
                                  <a class="page-link" href="role?str'.($cisloStrana+1).'">Další</a>
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
        $idUzivatele = substr($celaURL, strrpos($celaURL, 'l')+1);
        $sqlv = "SELECT * FROM `uzivatele` WHERE id=$idUzivatele;"; 	//limit - max int
        $vysv= mysqli_query($pripojeni,$sqlv);
        $rowv = mysqli_fetch_assoc($vysv);
        echo '
         <div id="nastaveniContainer">
          <section class="text-center">
            <div class="row py-lg-5" style="margin-right:0px;">
              <div class="col-lg-6 col-md-8 mx-auto">';
                  include "includes/errorVypis.php";
                echo '
                <h1 class="fw-light">Profil uživatele</h1>
                <p class="lead text-muted">V této sekci máte možnost upravit pozici uživatele. Dále se zde zobrazují informace o uživatelském účtu.</p>
                <p>
                  <hr>
                  <form class="formularFoto">';
            		if($rowv['profilovka'] == 1){
                    $filename="../photos/profile/profile".$idUzivatele."*";
                    $fileinfo=glob($filename);
                    $fileext=explode(".",$fileinfo[0]);
              			echo '<img src="../photos/profile/profile'.$idUzivatele.'.'.$fileext[3].'" id="profilFotoNastaveni" width="200" height="200" alt="Profilová fotka">';
              		}if($rowv['profilovka'] == 0){
              			echo '<img src="../photos/profile/default.jpg" id="profilFotoNastaveni" width="200" height="200" alt="Profilová fotka">';
            	    }
                  echo '
                  </form>
                <br>
                <hr>
                <h5 class="fw-light">Informace o účtu</h5>
                <form action="../scripts/editRole" method="POST">
                    <input class="form-control" disabled type="text" value="Jméno a příjmení: '.$rowv['jmeno'].' '.$rowv['prijmeni'].'" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">
                    <input class="form-control" disabled type="text" value="E-mail: '.$rowv['email'].'" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">
                    <input class="form-control" disabled type="text" value="Tel. číslo: '.$rowv['telcis'].'" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">
                    ';
                    if($rowv['ban']==0)
                        echo '<input class="form-control" disabled type="text" value="Stav BANU: NEZABANOVÁN" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">';
                    else
                        echo '<input class="form-control" disabled type="text" value="Stav BANU: ZABANOVÁN" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">';

                    echo '
                    <select class="form-select" name="pozice" aria-label="Default select example" style="margin-top:20px;margin-bottom:20px;max-width:600px;margin-left: auto;margin-right: auto;">
                      <option value="'.$rowv['pozice'].'" selected>Pozice: '.$rowv['pozice'].'</option>';
                      if($rowv['pozice']!="Montér"){
                        echo '<option value="Montér">Nastavit pozici: Montér</option>';
                      }
                      if($rowv['pozice']!="Skladník"){
                        echo '<option value="Skladník">Nastavit pozici: Skladník</option>';
                      }
                      if($rowv['pozice']!="Šéf"){
                        echo '<option value="Šéf">Nastavit pozici: Šéf</option>';
                      }
                    echo '
                    </select>
                    <input type="hidden" name="idUzivatele" value="'.$rowv['id'].'">
                    <button class="btn btn-primary" name="upravPozici" type="submit" style="margin-top:20px;margin-bottom:20px; margin-right:10px;">Upravit pozici</button>';
                    if($_SESSION['poziceUzivatele'] == "Administrátor")
                        echo '<a href="menu" class="btn btn-secondary" type="button" style="margin-top:20px;margin-bottom:20px;">Zpět</a>';
                    else
                        echo '<a href="role" class="btn btn-secondary" type="button" style="margin-top:20px;margin-bottom:20px;">Zpět</a>';
                    echo '
                </form>
                <hr>';
                if($_SESSION['poziceUzivatele'] == "Administrátor"){
                    echo '
                    <h5 class="fw-light">Administrátorské služby</h5>
                    <div style="display: inline-flex;">';
                    if($rowv['ban']==0){
                    echo '
                    <form action="../scripts/menuProved" method="POST" style="float:left;margin: 5px 5px 5px;">
                        <!-- Button BAN -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalBAN">
                          Zabanovat uživatele
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalBAN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Opravdu si přejete zabanovat uživatele?</h5>
                              </div>
                              <div class="modal-body">
                                Kliknutím na tlačítko ZABANOVAT, zabanujete uživatele. Změny jsou možné!
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" name="idUzivatele" value="'.$rowv['id'].'">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                <button type="submit" name="zabanovatSubmit" class="btn btn-primary">ZABANOVAT</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>';
                    }
                    else{
                        echo '
                        <form action="../scripts/menuProved" method="POST" style="float:left;margin: 5px 5px 5px;">
                        <!-- Button UNBAN -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalUNBAN">
                          UNbanovat uživatele
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalUNBAN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Opravdu si přejete UNbanovat uživatele?</h5>
                              </div>
                              <div class="modal-body">
                                Kliknutím na tlačítko UNBANOVAT, unbanujete uživatele. Změny jsou možné!
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" name="idUzivatele" value="'.$rowv['id'].'">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                <button type="submit" name="unbanovatSubmit" class="btn btn-primary">UNBANOVAT</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                        ';
                    }
                    echo '
                    <form action="../scripts/menuProved" method="POST" style="float:left;margin: 5px 5px 5px;">
                        <!-- Button smazani uzivatele -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalsmazat">
                          Smazat uživatele
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalsmazat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Opravdu si přejete smazat uživatele?</h5>
                              </div>
                              <div class="modal-body" style="text-align:left;">
                                Kliknutím na tlačítko Smazat uživatele smažete uživatelský profil. Veškeré změny nejsou možné vrátit zpět!<br><br>
                                V případě, že smažete učet, pro který už existují nějaké záznamy je třeba přejít do databáze a promazat zbývající záznamy ručně! Před tím než tuto operaci provedete prokonzultujte ji s šéfem firmy!
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" name="idUzivatele" value="'.$rowv['id'].'">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                <button type="submit" name="smazatSubmit" class="btn btn-primary">Smazat uživatele</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                    </div>
                    ';
                }
                echo '
               </p>
              </div>
            </div>
          </section>
      </div>';
     }
    ?>
</body>
</html>
