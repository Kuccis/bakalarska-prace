<!DOCTYPE html>
<html lang="cs">

<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/skladStyle.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     include "includes/navbar.php";
    ?>
    
    <?php
      if($_SESSION['poziceUzivatele'] != "nezadáno"){
          echo '
          <div id="navItems" class="px-4 text-center bg-light">
            <div class="d-flex hledaciPole">
            <button type="button" style="margin-right:auto;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
              Nákupní košík <i class="fa-solid fa-cart-shopping"></i>
            </button>
            
            <!-- Modal pro nákupní košík -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Váš nákupní košík a jeho obsah</h5>
                    <a href="skladiste?akce=odstranitVse" type="button" class="btn btn-danger">
                        Odstranit vše
                    </a>
                  </div>
                  <div class="modal-body">';
                    if(!empty($_GET["akce"])){
                        switch($_GET["akce"]) {
                        	case "pridat": 
                        	    $pomKod=$_GET["kod"];
                        	    $pocet=$_POST['pocet'];
                        	    $bool=0;    //kontroluje jestli se vykonala vetev ve foreach, pokud ano neprida se vec do seznamu
                                $sqlT = "SELECT * FROM `skladiste` WHERE id=$pomKod;";
                                $vysT = mysqli_query($pripojeni,$sqlT);
                                while($rowT = mysqli_fetch_assoc($vysT)){
                                    $vec[]=$rowT;
                                }
                        	    
                        	    $pomPole=array($vec[0]["id"]=>array('pocet'=>$_POST["pocet"], 'id'=>$vec[0]["id"]));    
                        	   
                        	    if(!empty($_SESSION['idVeci'])){
                            			foreach($_SESSION["idVeci"] as $i => $v) {
                                				if($_SESSION["idVeci"][$i]["id"] == $pomKod) {
                                					if(empty($_SESSION["idVeci"][$i]["pocet"])) {
                                						$_SESSION["idVeci"][$i]["pocet"] = 1;
                                					}
                                					$_SESSION["idVeci"][$i]["pocet"] += $_POST["pocet"];
                                					$bool=1; 
                                					break;
                                				}
                            			}
                            			if($bool==0)
                            			{
                                        	$_SESSION["idVeci"] = array_merge($_SESSION["idVeci"],$pomPole);
                                        	break;
                            			}
                        	        }
                        	    else
                        	        $_SESSION['idVeci']=$pomPole;
                        	break;
                        	case "odstranit":
                        	    //odstranuje veci z pole veci
                        		if(!empty($_SESSION["idVeci"])) {
                            		foreach($_SESSION["idVeci"] as $k => $v) {  //prochazime vsechny prvky pole
                            			if($_GET["kod"] == $_SESSION["idVeci"][$k]["id"])   //pokud se prvek pole na indexu rovna s cislem predavanym v URL tak se prvek smaze
                            				unset($_SESSION["idVeci"][$k]);				
                            			if(empty($_SESSION["idVeci"]))  //pokud je pole prazdne kompletne ho odstranime
                            				unset($_SESSION["idVeci"]);
                            		}
                            	}
                        	break;
                        	case "odstranitVse":
                        		unset($_SESSION["idVeci"]);
                        	break;
                        }
                        
                    }
                    if(isset($_SESSION['idVeci'])){
                    echo '
                      <table class="table" style="vertical-align:middle;">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Název</th>
                              <th scope="col">Počet</th>
                              <th scope="col"></th>
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
                                 echo '<th scope="row"><img src="../photos/items/defaultItem.jpg" style="width:80px;height:45px;"></th>';
                                else
                                {
                                  $filename="../photos/items/item".$rowVec['id']."*";
                                  $fileinfo=glob($filename);
                                  $fileext=explode(".",$fileinfo[0]);
                                 echo '<th scope="row"><img src="../photos/items/item'.$rowVec['id'].'.'.$fileext[3].'" style="width:80px;height:50px;"></th>';    
                                }
                                echo '
                                 <td>'.$rowVec['nazev'].'</td>
                                 <td><input type="text" class="vecPoc" name="pocet" disabled value="'.$cisloVeci['pocet'].'" min=1 max='.$rowVec['pocet'].' size="3" /> '.$rowVec['ksm'].'</td>
                                 <td>
                                    <a href="skladiste?akce=odstranit&kod='.$rowVec['id'].'" type="button" class="btn btn-dark"><em class="fa fa-trash"></em></a>
                                 </td>
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
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>';
                    if(!isset($_SESSION['idVeci']))
                        echo '<a href="" type="button" class="btn btn-primary disabled">Přejít k objednávce</a>';
                    else
                         echo '<a href="skladisteFinal" type="button" class="btn btn-primary">Přejít k objednávce</a>';
                    echo '
                  </div>
                </div>
              </div>
            </div>
          <a href="skladiste" type="button" style="margin-right:5px;" class="btn btn-success"><i class="fa-solid fa-house"></i></a>
          ';
          if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Administrátor")
          {
            echo '
                <a href="skladPridat" class="btn btn-danger">Přidat věc do skladiště</a>
            ';
          }
      }
      else
      {
          echo '
          <div style="margin-left: 280px;transition: 0.5s;">
             <section class="text-center">
               <div class="row py-lg-5" style="margin-right:0px;">
                 <div class="col-lg-6 col-md-8 mx-auto">
                   <h1 class="fw-light">Skladiště</h1>
                   <p class="lead text-muted">Tato sekce není prozatím dostupná! Váš nadřízený Vám musí nejprve nastavit roli!</p>
                 </div>
               </div>
             </section>
            </div>';
      }
      ?>
 	      <?php
 	      if($_SESSION['poziceUzivatele'] != "nezadáno"){
 	      echo '<form class="d-flex searchBar" action="../scripts/vyhledatVec" method="POST">
                    <input type="text" class="form-control hledanaVec" name="textHledaneVeci" placeholder="Zde zadejte název věci, kterou hledáte">
                    <button class="btn btn-primary" type="submit" name="vyhledejPoleVec">Vyhledat</button>
                  </form>
                </div>';
                $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(strpos($celaURL,'skladiste') !== false && strpos($celaURL,'skladiste?vec') == false)
                {
                    echo '
                    <nav class="navbar navbar-light bg-light">
                        <div class="row col">
                          <a href="?elnar" type="button" class="btn btn-light">Elektrické nářadí</a>
                          <a href="?naradi" type="button" class="btn btn-light">Nářadí</a>
                          <a href="?switche" type="button" class="btn btn-light">Switche</a>
                        </div>
                        <div class="row col" style="margin-left:20px;">
                          <a href="?routery" type="button" class="btn btn-light">Routery</a>
                          <a href="?elektroinsta" type="button" class="btn btn-light">Elektroinstalace</a>
                          <a href="?lanprohre" type="button" class="btn btn-light">Lana, provazy, hřebíky, ..</a>
                        </div>
                        <div class="row col" style="margin-left:20px;">
                          <a href="?zabezpeceni" type="button" class="btn btn-light">Zabezpečení</a>
                          <a href="?drakon" type="button" class="btn btn-light">Dráty, konektory a další</a>
                          <a href="?ostatni" type="button" class="btn btn-light">Ostatní</a>
                        </div>
                    </nav>';
                }
              echo '
              </div>
              <div class="shopList panel-body">
                
                <table class="table table-list">';
                $hledane = $_SESSION['hledanaVec'];
                if(strpos($celaURL,'elnar'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=1;";
                else if(strpos($celaURL,'naradi'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=2;";
                else if(strpos($celaURL,'switche'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=3;";
                else if(strpos($celaURL,'routery'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=4;";
                else if(strpos($celaURL,'elektroinsta'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=5;";
                else if(strpos($celaURL,'lanprohre'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=6;";
                else if(strpos($celaURL,'zabezpeceni'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=7;";
                else if(strpos($celaURL,'drakon'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=8;";
                else if(strpos($celaURL,'ostatni'))
                  $sql = "SELECT * FROM `skladiste` WHERE sekce=9;";
                else if(strpos($celaURL, 'editace==uspesna') || strpos($celaURL, 'editace==neuspesna') || strpos($celaURL, 'akce') || strpos($celaURL, 'odstraneniVeci=uspesne') || strpos($celaURL, 'objednavka==uspesna') || strpos($celaURL, 'objednavka==neuspesna') || strpos($celaURL, 'objednavka==nevyplnena'))
                  $sql = "SELECT * FROM `skladiste`;";
                else if($_SESSION['vyhledano']==1){
                  $bezHacku=iconv('utf-8', 'ascii//TRANSLIT', $hledane);    // prevadi string s hackama a carkama na string bez hacku a carek
                  $sql = "SELECT * FROM `skladiste` WHERE nazev LIKE '%$hledane%' OR nazev LIKE '%$bezHacku%';";
                  $_SESSION['vyhledano']=0;
                  unset($_SESSION['hledanaVec']);   //po vyhledani a vypsani se tato session zrusi. Nastavi se znovu až poté co uživatel zadá nový požadavek na vyhledání
                }
                else
                  $sql = "SELECT * FROM `skladiste`;";
        
                $vys = mysqli_query($pripojeni,$sql);
                $pocetItemu=mysqli_num_rows($vys);
                if($pocetItemu > 0){
                  echo '<div class="container">';
                        include "includes/errorVypis.php";
                        if(strpos($celaURL,'skladiste') !== false && strpos($celaURL,'skladiste?vec') == false)
                        {
                        echo '
                        <div class="shop-default shop-cards shop-tech">
                            <div class="row">';
                              while($row = mysqli_fetch_assoc($vys)){
                                echo '
                                <div class="col-md-3" style="margin-top:20px;min-width:270px;max-width:330px;">
                                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                                        <div class="block-image">';
                                            if($row['foto']==0){
                                                echo '<img src="../photos/items/defaultItem.jpg" class="img-center" style="height: 170px;width: -webkit-fill-available;margin:5px;">';
                                            }
                                            else
                                            {
                                                $filename="../photos/items/item".$row['id']."*";
                                                $fileinfo=glob($filename);
                                                $fileext=explode(".",$fileinfo[0]);
                                                echo '<img src="../photos/items/item'.$row['id'].'.'.$fileext[3].'" class="img-center" style="height: 170px;width: -webkit-fill-available;margin:5px;">';
                                           }
                                            echo '
                                        </div>
                                        <div class="block-body text-center">
                                            <h3 class="heading heading-5">
                                                <a href="skladiste?vec'.$row['id'].'" style="text-decoration: none;">
                                                    '.$row['nazev'].'
                                                </a>
                                            </h3>
                                            <div class="product-colors mt-2">';
                                                if($row['pocet']>0)
                                                    echo '<div class="skladem">Skladem</div>';
                                                else
                                                    echo '<div class="neskladem">Není skladem</div>';
                                                echo '
                                            </div>
                                            <div class="product-buttons mt-4">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <form action="skladiste?akce=pridat&kod='.$row['id'].'" method="POST" style="float:right;">
                                                            ';
                                                            if($row['pocet']>0){
                                                                echo '
                                                                <input type="number" class="pocetVec" name="pocet" value="1" min=1 max='.$row['pocet'].' size="3" /> '.$row['ksm'].'
                                                                <button type="submit" class="btn btn-outline-secondary">Přidat do košíku <i class="fa-solid fa-cart-shopping"></i></button>
                                                                ';
                                                            }
                                                            else
                                                            {
                                                                echo '
                                                                <input type="text" disabled value="0" class="pocetVec" > '.$row['ksm'].'
                                                                <button type="submit" class="btn btn-outline-secondary disabled">Přidat do košíku <i class="fa-solid fa-cart-shopping"></i></button>
                                                                ';
                                                            }
                                                        echo '
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                  }
                  else
                  {
                      $id = substr($celaURL, strrpos($celaURL, 'c')+1);
                      $sqlvy = "SELECT * FROM `skladiste` WHERE id=$id;";
                      $vysvy = mysqli_query($pripojeni,$sqlvy);
                      $rowvy = mysqli_fetch_assoc($vysvy);
                      echo '
                      <div class="container bootdey">
                        <div class="col-md-12">
                        <section class="panel">
                              <div class="panel-body">
                                  <div class="col-md-6" style="float:left;">
                                      <div class="pro-img-details" style="margin-left:15px;margin-right:15px;">';
                                          if($rowvy['foto']==0){
                                                echo '<img src="../photos/items/defaultItem.jpg" class="img-center" style="height: 330px;max-width:550px;margin:5px;">';
                                            }
                                            else
                                            {
                                                $filename="../photos/items/item".$rowvy['id']."*";
                                                $fileinfo=glob($filename);
                                                $fileext=explode(".",$fileinfo[0]);
                                                echo '<img src="../photos/items/item'.$rowvy['id'].'.'.$fileext[3].'" class="img-center" style="height: 330px;max-width:550px;margin:5px;">';
                                           }
                                           echo'
                                      </div>
                                  </div>
                                  <div class="col-md-6" style="float:left;white-space: initial;word-wrap: break-word;">
                                      <h4 class="pro-d-title">
                                         '.$rowvy['nazev'].'
                                      </h4>
                                      <p>
                                         '.$rowvy['text'].'
                                      </p>
                                      <div class="product_meta">
                                          <span class="posted_in"> <strong>Kategorie: </strong>';
                                            if($rowvy['sekce']==1)
                                                echo 'elektrické nářadí';
                                            else if($rowvy['sekce']==2)
                                                echo 'nářadí';
                                            else if($rowvy['sekce']==3)
                                                echo 'switche';
                                            else if($rowvy['sekce']==4)
                                                echo 'routery';
                                            else if($rowvy['sekce']==5)
                                                echo 'elektroinstalace';
                                            else if($rowvy['sekce']==6)
                                                echo 'lana, provazy, hřebíky, ..';  
                                            else if($rowvy['sekce']==7)
                                                echo 'zabezpečení';
                                            else if($rowvy['sekce']==8)
                                                echo 'dráty, konektory a další';
                                            else if($rowvy['sekce']==9)
                                                echo 'ostatní';
                                            echo '
                                          </span>
                                      </div>
                                      <div class="m-bot15"> <strong>Cena : </strong> <span class="pro-price"> '.$rowvy['cena'].' Kč</span></div>
                                      <div class="form-group">
                                          <label>Cena je pouze informativní. Při objednání nic neplatíte!</label>
                                      </div>
                                      <p style="margin-top:15px;">';
                                        if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Administrátor"){
                                            echo '
                                                <div style="margin-top:20px;">
                                                  <form>
                                                     <a href="editorVec?vec'.$rowvy['id'].'" type="button" class="btn btn-secondary">Editovat věc <em class="fa fa-pencil"></em></a>
                                                  </form>
                            
                                                  <button type="button" class="btn btn-dark" style="margin-left:5px;" data-toggle="modal" data-target="#exampleModalDelete'.$rowvy['id'].'">
                                                    Odstranit věc <em class="fa fa-trash"></em>
                                                  </button>
                                                  <!-- Modal -->
                                                  <div class="modal fade" id="exampleModalDelete'.$rowvy['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLongTitle">Odstranit věc</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                          Jste si jistí, že opravdu chcete odstranit tuto věc ze skladiště? Vaše změny nebudou možné vrátit zpět!
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                                          <form style="float:left;margin-left:5px;" method="POST" action="../scripts/odstranitVec">
                                                            <input type="hidden" name="idVecHidden" value="'.$rowvy['id'].'">
                                                            <button type="submit" name="odstranitVec" class="btn btn-danger">Odstranit</button>
                                                          </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                 </div>
                                                </div>';
                                        }
                                        echo '
                                      </p>
                                  </div>
                              </div>
                          </section>
                          </div>
                          <hr>
                          </div>
                          ';
                  }
                  echo '
                            </div>
                        </div>
                    </div>';
               }
               else {
                 echo '<h5>Ve skladišti nebyla nalezena vámi zadaná věc</h5>';
               }
 	      }
	     ?>
      </tbody>
    </table>
  </div>
</body>
</html>
