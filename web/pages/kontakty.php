<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/kontaktStyle.css">
    <title>Vítejte v Javosoftware!</title>
    <script>
    function hledat_kontakt() {
        let input = document.getElementById('myInput').value
        input=input.toLowerCase();
        let x = document.getElementsByClassName('card-body');
        let ramec=document.getElementsByClassName('kontakt');

        for (i = 0; i < x.length; i++) {
            if (!x[i].innerHTML.toLowerCase().includes(input)) {
                ramec[i].style.display="none";
            }
            else {
                ramec[i].style.display="block";
            }
        }
    }
    </script>
</head>
<body>
    <?php
     include "includes/navbar.php";
    ?>
    <div id="kontaktyContainer">
      <section class="text-center">
        <div class="row py-lg-5" style="margin-right:0px;">
          <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Kontakty</h1>
            <p class="lead text-muted">V této sekci naleznete kontakty na všechny registrované uživatele. Každý uživatel má přiřazené své telefonní číslo, jméno, pracovní pozici a profilovou fotografii. V případě, že hledáte specifickou osobu využijte vyhledávacího pole.</p>
            <p>
              <form class="d-flex" style="justify-content: flex-end;">
                <input class="form-control" type="text" id="myInput" onkeyup="hledat_kontakt()" placeholder="Zde zadejte jméno osoby, kterou hledáte" aria-label="Search">
              </form>
            </p>
          </div>
        </div>
      </section>
      <div class="sekceKontakty">
      <?php
        $sql = "SELECT *  FROM `uzivatele`"; 	//limit - max int
        $vys= mysqli_query($pripojeni,$sql);
        $pocetUzivatelu=mysqli_num_rows($vys);
        if($pocetUzivatelu > 0){
          while($row = mysqli_fetch_assoc($vys)){
            echo '<div class="kontakt">
                  <div class="card px-4 my-5 text-center bg-light">';
                    if($row['profilovka']==0){
                      echo '<img class="card-img-top" style="margin-top:5%;" src="../photos/profile/default.jpg" alt="Default profilove fotografie">';
                    }
                    else {
              				$filename="../photos/profile/profile".$row['id']."*";
              				$fileinfo=glob($filename);
              				$fileext=explode(".",$fileinfo[0]);
                      echo '<img class="card-img-top" src="../photos/profile/profile'.$row['id'].'.'.$fileext[3].'" alt="Default profilove fotografie" style="margin-top:5%;width:238px;height: 238px;">';
                    }
                    echo '
                    <div class="card-body">
                      <p class="card-text">'.$row['jmeno']." ".$row['prijmeni'].', '.$row['pozice'].'<br><hr>Email: '.$row['email'].'<br>Tel. č.: '.$row['telcis'].'</p>
                    </div>
                  </div>
                  </div>';
          }
        }
        else {
          echo '<h1>Žádné kontakty k zobrazení</h1>';
        }
      ?>
    </div>
  </div>
</body>
</html>
