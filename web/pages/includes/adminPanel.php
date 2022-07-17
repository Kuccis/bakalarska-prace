<?php
$sql = "SELECT *  FROM `uzivatele`"; 
$vys= mysqli_query($pripojeni,$sql);
$pocetUzivatelu=mysqli_num_rows($vys);

$sqlObj = "SELECT *  FROM `objednavkySklad`"; 
$vysObj= mysqli_query($pripojeni,$sqlObj);
$pocetObj=mysqli_num_rows($vysObj);

$sqlu = "SELECT *  FROM `ukoly`"; 
$vysu= mysqli_query($pripojeni,$sqlu);
$pocetu=mysqli_num_rows($vysu);

echo '
  <div class="container">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="nadpisKarta">Počet objednávek</h6>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>'.$pocetObj.'</span></h2>
                    <p class="m-b-0"><a href="menu?objednavky" style="color:white;font-weight:bold;">Zobrazit data</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="nadpisKarta">Počet registrovaných uživatelů</h6>
                    <h2 class="text-right"><i class="fa-solid fa-user-check f-left"></i><span>'.$pocetUzivatelu.'</span></h2>
                    <p class="m-b-0"><a href="menu?uzivatele" style="color:white;font-weight:bold;">Zobrazit data</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="nadpisKarta">Počet vláken v Helpdesku</h6>
                    <h2 class="text-right"><i class="far fa-question-circle f-left"></i><span>---</span></h2>
                    <p class="m-b-0"><a href="" style="color:white;font-weight:bold;">Zobrazit data</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="nadpisKarta">Počet zadaných úkolů</h6>
                    <h2 class="text-right"><i class="fa-solid fa-calendar-days f-left"></i><span>'.$pocetu.'</span></h2>
                    <p class="m-b-0"><a href="menu?ukoly" style="color:white;font-weight:bold;">Zobrazit data</a></p>
                </div>
            </div>
        </div>
	</div>
</div>';
       ?>