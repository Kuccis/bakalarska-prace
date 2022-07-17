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
        include "includes/navbar.php";
        $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
        $idVecHidden=substr($celaURL, strrpos($celaURL, 'c')+1);
        $sqli = "SELECT *  FROM `skladiste` WHERE id=$idVecHidden;";
        $vysi= mysqli_query($pripojeni,$sqli);
        $rowi = mysqli_fetch_assoc($vysi);
        echo '
           <div id="uvodniTextikk" class="px-4 my-5 text-center">
             <h1 class="fw-light">Editor věcí</h1>
             <div class="col-lg-6 mx-auto">
               <p class="lead mb-4 text-muted">Tento editor slouží k upravení vystavených věcí na skladišti. V případě, že dojde k hlavním změnám pro jistotu uvědomte Vašeho pracovníka! Nemusel by si změn všimnout.
               </p>
             </div>
             <div class="pozadiSef">
             <form method="POST" enctype="multipart/form-data" action="../scripts/editVec" class="formEdit">
             <div class="menuUloha">
               <input type="hidden" name="idVecHidden" value="'.$idVecHidden.'">';
               if($rowi['foto']==0)
                 echo '<img src="../photos/items/defaultItem.jpg" style="width:320px;height:220px;">';
               else
               {
                 $filename="../photos/items/item".$rowi['id']."*";
                 $fileinfo=glob($filename);
                 $fileext=explode(".",$fileinfo[0]);
                 echo '
                 <img src="../photos/items/item'.$rowi['id'].'.'.$fileext[3].'" style="width:320px;height:220px;">
                 ';
               }
               echo '
               <br><br>
               <input type="file" name="foto">
               <input type="hidden" name="idVecFoto" value="'.$rowi['id'].'">
               <br><br>
               <input type="text" class="form-control" name="nazevVec" value="'.$rowi['nazev'].'" placeholder="Zadejte název věci *"><br>
               <input type="text" class="form-control" name="cenaVec" value="'.$rowi['cena'].'" placeholder="Zadejte cenu (v Kč) *"><br>
               <input type="text" class="form-control" name="pocetVec" value="'.$rowi['pocet'].'" placeholder="Zadejte počet *"><br>
               <select class="form-control" name="jednotka"><br>
                <option value="">Vyberte jednotku *</option>';
                echo '<option selected="selected" value="'.$rowi['ksm'].'">'.$rowi['ksm'].'</option>';
                      if($rowi['ksm']!="ks")
                        echo '<option value="ks">ks</option>';
                      if($rowi['ksm']!="m")
                        echo '<option value="m">m</option>';
                      if($rowi['ksm']!="cm")
                        echo '<option value="cm">cm</option>';
               echo '</select><br>
               <select class="form-control" name="sekceVec"><br>';
                  if($rowi['sekce'] == 1)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Elektrické nářadí</option>';
                  else if($rowi['sekce'] == 2)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Nářadí</option>';
                  else if($rowi['sekce'] == 3)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Switche</option>';
                  else if($rowi['sekce'] == 4)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Routery</option>';
                  else if($rowi['sekce'] == 5)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Elektroinstalace</option>';
                  else if($rowi['sekce'] == 6)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Lana, provazy, hřebíky, ..</option>';
                  else if($rowi['sekce'] == 7)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Zabezpečení</option>';
                  else if($rowi['sekce'] == 8)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Dráty, konektory a další</option>';
                  else if($rowi['sekce'] == 9)
                    echo '<option selected="selected" value="'.$rowi['sekce'].'">Ostatní</option>';
                  if($rowi['sekce'] != 1)
                    echo '<option value="1">Elektrické nářadí</option>';
                  if($rowi['sekce'] != 2)
                    echo '<option value="2">Nářadí</option>';
                  if($rowi['sekce'] != 3)
                    echo '<option value="3">Switche</option>';
                  if($rowi['sekce'] != 4)
                    echo '<option value="4">Routery</option>';
                  if($rowi['sekce'] != 5)
                    echo '<option value="5">Elektroinstalace</option>';
                  if($rowi['sekce'] != 6)
                    echo '<option value="6">Lana, provazy, hřebíky, ..</option>';
                  if($rowi['sekce'] != 7)
                    echo '<option value="7">Zabezpečení</option>';
                  if($rowi['sekce'] != 8)
                    echo '<option value="8">Dráty, konektory a další</option>';
                  if($rowi['sekce'] != 9)
                    echo '<option value="9">Ostatní</option>';
                  echo '
               </select><br>
               <textarea name="textUlohy">
                '.$rowi['text'].'
               </textarea>
             </div>
             <br>
             <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
               <button type="submit" name="submitEdit" class="btn btn-primary px-4 gap-3">Editovat věc</button>
               <a href="skladiste?vec'.$idVecHidden.'" type="button" class="btn btn-outline-secondary px-4">Zpět</a>
             </div>
             </form>
             <br>
             </div>
           </div>
        '; 
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
