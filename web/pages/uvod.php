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
     
       echo '
       <div id="uvodniTextikk" class="px-4 my-5 text-center">';
         include "includes/errorVypis.php";
         echo '
         <i class="fab fa-hotjar fa-6x"></i>
         <h1 class="display-5 fw-light">Vítejte v Javosoftware!</h1>
         <div class="col-lg-6 mx-auto">
           <p class="lead mb-4 text-muted">Tato aplikace slouží k přehlednému digitálnímu sdílení a zaznamenávání dat. Na moderní a jednoduchý design bylo při tvorbě cíleno, tak aby Vaše práce byla co nejvíce plynulá a bezstarostná.<br><b>V případě, že si s něčím nevíte rady klikněte na tlačítko "Jak začít".</b></br></p>
           <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
             <a href="jakzacit" type="button" class="btn btn-primary btn-lg px-4 gap-3">Jak začít</a>
             <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-toggle="modal" data-target="#exampleModal">
                  Report
             </button>
                
             <!-- Modal -->
             <form action="uvod" method="POST">
                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                       <div class="modal-content">
                         <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Report</h5>
                         </div>
                       <div class="modal-body" style="text-align:left;">
                            <p>Nastal problém? Prosím popište jej co nejpodrobněji do textového pole níže.</p>
                            <textarea style="width: 100%;" name="reportText"></textarea>
                       </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                          <button type="submit" name="odeslatReport" class="btn btn-primary">Odeslat</button>
                       </div>
                    </div>
                 </div>
             </form>
            </div>
           </div>
         </div>
       </div>
       ';
    ?>
    <?php
        
        if(isset($_POST['odeslatReport'])){
             $textZprava=$_POST['reportText'];
             $jmeno=$_SESSION['jmeno'];
             $prijmeni=$_SESSION['prijmeni'];
             $mail=$_SESSION['emailUzivatele'];
             
             $to      = 'kucera30@student.vspj.cz';
             $subject = 'Report z webu Javo Software';
             $message = '.$textZprava.';
             $headers = 'From: $mail'       . "\r\n" .
                        'Reply-To: $mail' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
             
             $retval = mail ($to,$subject,$message,$header);
             
             if( $retval == true ) {
                echo "Message sent successfully...";
             }else {
                echo "Message could not be sent...";
             }
        }
      ?>
</body>
</html>
