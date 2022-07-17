<?php
	session_start();
	include_once 'scripts/dtb.php'
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "pages/includes/head_incl.php";
    ?>
    <title>Přihlaste se do Javosoftware!</title>
    <link rel="stylesheet" href="css/formulareLogReg.css">
</head>
<body>
  <form class="container container-small text-center" method="post" action="scripts/login.php">
    <?php
        include "pages/includes/errorVypis.php";
    ?>
    <i class="fas fa-sign-out-alt fa-5x"></i>
    <h1 class="h3 mb-4 fw-normal">Přihlašte se do Javosoftware</h1>

    <div class="form-floating mb-2">
      <input type="email" class="form-control" id="floatingInput" name="email" placeholder="-">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" id="floatingPassword" name="heslo1" placeholder="Heslo">
      <label for="floatingPassword">Heslo</label>
    </div>
    <div class="muted mb-2">
	     <a href="">Zapomenuté heslo</a>
    </div>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Zapamatovat si
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mb-4" type="submit" name="login">Přihlásit se</button>
    <div class="muted ">
      <a href="pages/registrace">Nemáte účet? Registrujte se kliknutím zde!</a>
    </div>
  </form>
</body>
</html>
