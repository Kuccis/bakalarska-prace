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
    <title>Registrujte se do Javosoftware!</title>
    <link rel="stylesheet" href="../css/formulareLogReg.css">
</head>
<body>
  <form class="container container-small text-center" method="POST" action="../scripts/registrace.php">
    <?php
        include "includes/errorVypis.php";
    ?>
    <i class="fas fa-sign-out-alt fa-5x"></i>
    <h1 class="h3 mb-4 fw-normal">Registrujte se do Javosoftware</h1>

    <div class="form-floating mb-2">
      <input type="text" class="form-control" id="jmeno" name="jmeno" placeholder="-">
      <label for="jmeno">Jméno</label>
    </div>
    <div class="form-floating mb-2">
      <input type="text" class="form-control" id="prijmeni" name="prijmeni" placeholder="-">
      <label for="prijmeni">Příjmení</label>
    </div>
	<div class="form-floating mb-2">
	    <input type="text" class="form-control" id="telcis" name="telcis" placeholder="Tel. číslo">
		<label for="telcis">Tel. číslo</label>
	</div>
    <div class="form-floating mb-2">
      <input type="email" class="form-control" id="email" name="email" placeholder="-">
      <label for="email">Email </label>
    </div>
    <div class="form-floating mb-2">
      <input type="password" class="form-control" id="heslo1" name="heslo1" placeholder="Heslo">
      <label for="heslo1">Heslo</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" id="heslo2" name="heslo2" placeholder="Heslo znovu">
      <label for="heslo2">Opakujte heslo</label>
    </div>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="souhlasim_se_zpracovanim_udaju" id="gdprCheck" name="gdprCheck"> Souhlasím s použitím osobních údajů.
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mb-4" type="submit" name="registrace">Registrovat se</button>
    <div class="muted ">
      <a href="../../index">Zpět k přihlášení se dostanete kliknutím zde!</a>
    </div>
  </form>
</body>
</html>
