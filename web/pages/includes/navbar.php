<?php
	session_start();
	include_once '../scripts/dtb.php';
	
	$id=$_SESSION['idUzivatele'];
	$sql = "SELECT * FROM uzivatele WHERE id=?;";
	$stmt = mysqli_stmt_init($pripojeni);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header("Location: ../index?error=sqlerror");
		exit();
	}
	else {
		mysqli_stmt_bind_param($stmt,"s", $id);
		mysqli_stmt_execute($stmt);
		$vys = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($vys);
		$_SESSION['stavBan']=$row['ban'];
		$_SESSION['poziceUzivatele'] = $row['pozice'];
	}
?>
<?php
	if(!isset($_SESSION['idUzivatele']))
	{
		header("Location: ../index.php");
	}
	else if($_SESSION['stavBan'] == 1){
	    header("Location: ../index.php?ban==aktivni");
	}
?>

<link rel="stylesheet" href="../css/navbar.css">



<div id="navMenu" class="d-flex flex-column flex-shrink-0 p-3 bg-light nav">
    <a href="../pages/uvod" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <i class="fab fa-hotjar fa-2x" style="margin-right:10px;"></i>
      <span class="fs-4">Javosoftware</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="../pages/uvod" class="nav-link link-dark">
          <i class="fas fa-chalkboard-teacher" style="margin-right:3px;"></i>
          Nástěnka
        </a>
      </li>
      <li>
        <a href="../pages/skladiste" class="nav-link link-dark">
          <i class="fa-solid fa-box-archive" style="margin-right:3px;"></i>
          Skladiště
        </a>
      </li>
      <li>
        <a href="../pages/kalendar" class="nav-link link-dark">
          <i class="fa-solid fa-calendar-days" style="margin-right:3px;"></i>
          Kalendář
        </a>
      </li>
      <li>
        <a href="../pages/ucet" class="nav-link link-dark">
          <i class="fa-solid fa-wallet" style="margin-right:3px;"></i>
          Vyúčtování
        </a>
      </li>
      <li>
        <a href="../pages/kontakty" class="nav-link link-dark">
          <i class="fa-solid fa-address-book" style="margin-right:3px;"></i>
          Kontakty
        </a>
      </li>
      <hr>
      <?php
      if($_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Skladník" || $_SESSION['poziceUzivatele']=="Administrátor")
      {
          echo '
            <li>
              <a href="../pages/objednavky" class="nav-link link-dark">
                <i class="fa-solid fa-cart-shopping" style="margin-right:3px;"></i>
                Objednávky
              </a>
            </li>
          ';
      }
      ?>
      <li>
        <a href="../pages/vaseobjednavky" class="nav-link link-dark">
            <i class="fa-solid fa-cart-arrow-down" style="margin-right:3px;"></i>
            Vaše objednávky
        </a>
      </li>
    </ul>
    <ul class="nav nav-pills flex-column">
      <li>
        <a href="../pages/helpdesk" class="nav-link link-dark">
          <i class="far fa-question-circle" style="margin-right:3px;"></i>
          Helpdesk
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
  <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:auto;">
		<?php
			if($_SESSION['statusUzivatele']==0)
			{
				echo '<img src="../../photos/profile/default.jpg" alt="" width="32" height="32" class="rounded-circle me-2">';
			}
			else {
				$sessionid=$_SESSION['idUzivatele'];
				$filename="../photos/profile/profile".$sessionid."*";
				$fileinfo=glob($filename);
				$fileext=explode(".",$fileinfo[0]);
				echo '<img src="../../photos/profile/profile'.$sessionid.'.'.$fileext[3].'" alt="" width="32" height="32" class="rounded-circle me-2">';
			}
		?>
    <strong><?php echo $_SESSION['jmenoUzivatele']." ".$_SESSION['prijmeniUzivatele']; ?></strong>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?php
    if($_SESSION['poziceUzivatele']=="Šéf")
    {
        echo '
            <a href="sazby" class="dropdown-item">Sazby</a>
            <a href="role" class="dropdown-item">Pozice</a>
        ';
    }
    if($_SESSION['poziceUzivatele']=="Administrátor")
    {
        echo '<a class="dropdown-item" href="menu">Řídící panel</a>';
    }
    ?>
    <a class="dropdown-item" href="nastaveni">Nastavení</a>
    <hr class="dropdown-divider">
    <a class="dropdown-item" href="../../scripts/odhlasit.php">Odhlásit se</a>
  </div>
</div>
</div>
