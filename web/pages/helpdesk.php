<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
     include "includes/head_incl.php";
    ?>
    <title>Vítejte v Javosoftware!</title>
    <link rel="stylesheet" href="../css/kalendarStyle.css">
</head>
<body>
    <?php
     include "includes/navbar.php";
     echo '
     <div class="kalendarContainer">
        <section class="text-center">
            <div class="row py-lg-5" style="margin-right:0px;">
                <div class="col-lg-6 col-md-8 mx-auto">';
                   include "includes/errorVypis.php";
                   echo '
                   <h1 class="fw-light">Helpdesk</h1>
                   <p class="lead text-muted">
                      Tato sekce se připravuje a prozatím nenabízí žádné služby!
                   </p>
                </div>
            </div>
        </section>
     </div>
     '
    ?>
</body>
</html>
