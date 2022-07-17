<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <link rel="stylesheet" href="../css/uvodStyle.css">
    <title>Vítejte v Javosoftware!</title>
</head>
<body>
    <?php
     include "includes/navbar.php";
     $idUziv=$_SESSION['idUzivatele'];
     $sql = "SELECT *  FROM `uzivatele` where id=$idUziv"; 	//limit - max int
     $vys= mysqli_query($pripojeni,$sql);
     $row = mysqli_fetch_assoc($vys);
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">
         <i class="fas fa-info-circle fa-6x"></i>
         <h1 class="display-5 fw-light">Informační sekce</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">
            Aplikace Javosoftware byla navržena tak aby byla co nejjednodušeji ovladatelná. V případě, že vám není něco jasné si administrátorský team připravil menší informační tutoriál jak se na webu orientovat a jak případné změny provádět.</br>
           </p>
         </div>
         <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4">
           <a href="uvod" type="button" class="btn btn-primary btn-lg px-4 gap-3">Zpět na úvodní stránku</a>
         </div>
         <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  K jakým účelům se dá tento web používat?
                </button>
              </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                Tato webová aplikace byla vytvořena za účelem snížení náročnosti na zaznamenávání pracovních postupů, stavu skladového materiálu a dalších věcí, které se týkají Vaší náplně práce.
                Pro vytvoření maximální přehlednosti a jednoduché spravovanosti bylo vytvořeno rolí, které se rozdělují dle pracovní pozice. Naleznete zde role, které mají za úkol zaznamenávat průběh práce, kontrolovat stav skladiště a nebo i například zadávat úlohy.
                Vše dohromady tedy tvoří propracované prostředí, které je velmi přehledné a zároveň jednoduché a všude dostupné.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Sekce skladiště
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                V sekci skladiště naleznete seznam všech věcí, které má firma na skladu. Každá věc má napsaný název, počet a jednotku, ve které se daný předmět vyjadřuje např. kabel v metrech, šroubovák v kusech.
                Pro vypůjčení věcí ze skladu klikněte na přidat do košíku. Poté co budete mít veškeré potřebné věci překliknete se na košík, který naleznete v horním pravém rohu. Následně seznam věcí, které jste vybral pouze přiřadíte k úkolu a můžete si věci osobně vyzvednout.
                Skladiště má různé funkce pro určité role.';
                if($row['pozice']=="Montér"){
                 echo '<br><b>Montér</b><br>  V případě, že jste pracovník, který využívá věci k montáži je k použití potřebné mít od nadřízeného nastavený úkol v kalendáři prací. Pokud nemáte žádné úkoly není totiž potřebné věci ze skladiště brát.';
                }
                else if($row['pozice']=="Skladník"){
                  echo '<br><b>Skladník</b><br>  V případě, že jste skladník je Vaším úkolem spravovat chod, celkový přehled a pravdivost firemního skladiště. Vaše možnosti jsou přidávat a odebírat položky ve skladišti.
                  Další kontroly je třeba provádět fyzicky na skladišti. K porovnání chybějících kusů lze použít kompletní seznam všech vypůjčení, který naleznete v menu po rozkliknutí šipky na navigačním menu u vašeho jméno s profilovou fotografií.
                  V případě, že naleznete nějaké neshody, chybějící věci a další, je možné kontaktovat osoby jenž si věci vypůjčili naposled a dát jim upozornění na navrácení. V případě, že neobdržíte zpětnou reakci ihned kontaktujte nadřízeného.';
                }
            echo ' </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Sekce kalendář
                </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                Sekce kalendář slouží k zobrazování aktuálních úloh, které Vám byli Vašim nadřízeným zadány.
                Ke každému úkolu máte možnost zapisovat progres a případně k němu přidávat i věci, které využijete ke splnění. Tyto věci vypůjčujete ve skladišti.
                V případě, že Váš úkol trvá více dní máte možnost tedy zaznamenávat veškeré důležité věci, kterými mohou být délka pracovní doby, seznam spotřebovaných věcí a další.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingFour">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Sekce vyúčtování
                </button>
              </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
              <div class="card-body">
                V sekci výúčtování naleznete funkci, která slouží k vypočítání faktury za odvedenou práci.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingFive">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Sekce HelpDesk
                </button>
              </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
              <div class="card-body">
                V této sekci naleznete kontaktní formulář pro náš team, který Vám poradí s každým problémem týkající se funkčnosti webu. Do této sekce se dostanete po rozkliknutí odkazu v navigačním menu.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingSix">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Sekce Nastavení
                </button>
              </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
              <div class="card-body">

              </div>
            </div>
          </div>
        </div>
       </div>
       ';
    ?>
</body>
</html>
