<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/nastaveni.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     include "includes/navbar.php";
    ?>
    <div id="nastaveniContainer">
      <section class="text-center">
        <div class="row py-lg-5" style="margin-right:0px;">
          <div class="col-lg-6 col-md-8 mx-auto">
            <?php
              include "includes/errorVypis.php";
            ?>
            <h1 class="fw-light">Nastavení</h1>
            <p class="lead text-muted">V této sekci máte možnost upravit Váš účet. Funkce nabízí změnu profilové fotografie, změnu telefonního čísla, změnu e-mailu a také změnu hesla. V případě, že si nevíte rady jak na změny, neváhejte a kontaktuje Help desk.</p>
            <p>
              <hr>
              <form class="formularFoto">
                <?php
        					$sessionid=$_SESSION['idUzivatele'];

        					if(isset($_SESSION['idUzivatele'])){
        						if($_SESSION['statusUzivatele'] == 1){
                      include "includes/najitFoto.php";
          						echo '<img src="../photos/profile/profile'.$sessionid.'.'.$fileext[3].'" id="profilFotoNastaveni" width="200" height="200" alt="Profilová fotka">';
          						}if($_SESSION['statusUzivatele'] == 0){
          						echo '<img src="../photos/profile/default.jpg" id="profilFotoNastaveni" width="200" height="200" alt="Profilová fotka">';
        						}
                    echo '<p id="upozorneniFoto">
                    Profilová fotografie musí být menší než 5mb. Podporovanými formáty jsou <strong>jpg, jpeg a png</strong>. Nahrané fotky nesmějí obsahovat rasový podtext,
                    případně xenofobní nebo urážlivé obrázky. Jakkoliv závádné fotky budou bez upozornění mazány.</p>';
        					}
        						?>

              </form>
              <?php
              if(isset($_SESSION['idUzivatele'])){
                if($_SESSION['statusUzivatele'] == 0)
                {
                  echo '<div class="fotoZmen">
                        <form action="../scripts/uploadProfilovky.php" method="post" enctype="multipart/form-data" id="vybratFot">
                          <input type="file" name="foto">
                          <button type = "submit" name="submit" class="btn btn-primary">Změnit profilovou fotku</button>
                          <input type="hidden" name="idUzivatele" value="'.$_SESSION['idUzivatele'].'">
                        </form></div>';
                }
                else{
                  echo '<div class="fotoZmen">
                        <form action="../scripts/smazaniProfilovky.php" method="post" id="smazatFoto">
                          <button type = "submit" name="submitSmazat" class="btn btn-primary" style="margin-top: 20px;">Smazat profilovou fotku</button>
                          <input type="hidden" name="idUzivatele" value="'.$_SESSION['idUzivatele'].'">
                        </form>
                        </div>';
                }
              }
            ?>
            <br>
            <hr>
            <h5 class="fw-light">Změna e-mailu</h5>
            <form class="d-flex" method="POST" action="../scripts/zmenMail.php">
              <input class="form-control" name="mailHodnota" type="email" placeholder="Zde zadejte nový e-mail" aria-label="Search" style="margin-top:20px;margin-bottom:20px;width:600px;">
              <input type="hidden" name="idUzivatele" value="<?php echo $_SESSION['idUzivatele']; ?>">
              <button class="btn btn-primary" name="submitMail" type="submit" style="margin-top:20px;margin-bottom:20px;">Změnit e-mail</button>
            </form>
            <hr>
            <h5 class="fw-light">Změna telefonního čísla</h5>
            <form class="d-flex" action="../scripts/zmenTelefon.php" method="post">
              <input class="form-control" type="text" name="novyTelefon" placeholder="Zde zadejte nové telefonní číslo" aria-label="text" style="margin-top:20px;margin-bottom:20px;width:600px;">
              <input type="hidden" name="idUzivatele" value="<?php echo $_SESSION['idUzivatele']; ?>">
              <button class="btn btn-primary" type="submit" name="zmenTelefon" style="margin-top:20px;margin-bottom:20px;">Změnit tel. č.</button>
            </form>
            <hr>
            <h5 class="fw-light">Změna hesla</h5>
            <form class="d-flex" action="../scripts/zmenHeslo.php" method="post">
              <input class="form-control" name="heslo1" type="password" placeholder="Zde zadejte nové heslo" aria-label="Search" style="margin-top:20px;margin-bottom:20px;max-width:300px;"><br>
              <input class="form-control" name="heslo2" type="password" placeholder="Zde zadejte nové heslo (znovu)" aria-label="Search" style="margin-top:20px;margin-bottom:20px;max-width:300px;">
              <input type="hidden" name="idUzivatele" value="<?php echo $_SESSION['idUzivatele']; ?>">
              <button class="btn btn-primary" name="zmenHeslo" type="submit" style="margin-top:20px;margin-bottom:20px;">Změnit heslo</button>
            </form>
           </p>
            <hr>
          </div>
        </div>
      </section>
  </div>
</body>
</html>
