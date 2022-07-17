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
    <link rel="stylesheet" href="../css/ucetStyle.css">
    <title>Javosoftware-účtenka</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">  
        function TiskDiv() {  
            var divContent = document.getElementById("tisk").innerHTML;  
            var printWindow = window.open('', '', 'height=700,width=900');  
            printWindow.document.write('<html><head><title></title>');  
            printWindow.document.write('<link rel="stylesheet" href="../css/ucetStyle.css">');
            printWindow.document.write('<link rel="stylesheet" href="../css/tisk.css">');
            printWindow.document.write('\x3Cscript type="text/javascript" src="https://kit.fontawesome.com/54e614519d.js">\x3C/script>');
            printWindow.document.write('</head><body style="font-family: Segoe UI !important;">');
            printWindow.document.write(divContent);  
            printWindow.document.write('</body></html>');
            printWindow.focus();
            setTimeout(function(){printWindow.print();},1000);
            printWindow.document.close();  
        }  
        function UdelejPdf() {  
        		var element = document.getElementById('tisk'); 
        		//more custom settings
        		var opt = 
        		{
        		  margin:       1,
        		  filename:     'uctenka.pdf',
        		  image:        { type: 'jpeg', quality: 0.98 },
        		  html2canvas:  { scale: 2 },
        		  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        		};
        
        		// New Promise-based usage:
        		html2pdf().set(opt).from(element).save();
	    }
    </script>  
</head>
<body>
    <?php
     $celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     $idUziv=$_SESSION['idUzivatele'];
     $idUkolu=substr($celaURL, strrpos($celaURL, 'l')+1);
     
     $sql = "SELECT * FROM `ukoly` WHERE id=$idUkolu;";
     $vys = mysqli_query($pripojeni,$sql);
     $row = mysqli_fetch_assoc($vys);
     if($row['zadany_monter_id'] == $idUziv || $_SESSION['poziceUzivatele']=="Šéf" || $_SESSION['poziceUzivatele']=="Administrátor"){
        $idObjednavky=$row['id'];
        $sqlu = "SELECT * FROM `uctenky` WHERE idUkolu=$idUkolu";
        $vysu = mysqli_query($pripojeni,$sqlu);
        $rowu = mysqli_fetch_assoc($vysu);
        
        $pocetUctenek=mysqli_num_rows($vysu);
        
        if($pocetUctenek == 0){
            header("Location: ../pages/ucet");
    		exit();
        }
        
        $osfir=$row['osfir'];
        $cp=$row['cp'];
        $psc=$row['psc'];
        $mesto=$row['mesto'];
        $ulice=$row['ulice'];
        
        $sazba=$rowu['hodSazba'];
        $odpracHod=$rowu['odpracHodin'];
        $pracovnikCena=$sazba*$odpracHod;
        
        $cena=$rowu['cena'];
        $dph=($cena/100)*21;
        $total=$cena+$dph;
        
        $totalZbozi=$cena-$pracovnikCena;
        
        $datum = strtotime($rowu['datum']);
     }
     else
     {
        header("Location: ../index?neopravnenyPristup");
    	exit();
     }
     
     //podminka pro zjisteni, ktera zajisti, ze se pri zadosti zobrazeni kalendare zobrazi opravdu pouze ukolnicek s kalendarem. Duvod - pro zobrazeni ukolu je potreba rozlisovat url od /kalendar a /kalendar?
     if(strpos($celaURL,'uctenka') != false && strpos($celaURL,'uctenka?ukol') != false)
     {
             include "includes/navbar.php";
             echo '
             <div class="ucetContainer">
              <div class="container-xl px-4 mt-4">
                <nav class="nav nav-borders">
                    <a class="nav-link" href="ucet?ukol'.$idUkolu.'">Formulář</a>
                    <a class="nav-link ms-0 active" href="uctenka?ukol'.$idUkolu.'">Účtenky</a>
                </nav>
                <hr class="mt-0 mb-4">
                <div class="row">
                    <div class="col-md-12">
                      <div class="invoice">
                         <!-- begin invoice-company -->
                         <div class="invoice-company text-inverse f-w-600">
                            <span class="pull-right hidden-print">
                            <button onclick="UdelejPdf();" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export do PDF</button>
                            <button onclick="TiskDiv();" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Tisk</button>
                            </span>
                            JAVO software s.r.o
                         </div>
                         <!-- end invoice-company -->
                         <!-- begin invoice-header -->
                         <div id="tisk">
                         <div class="invoice-header">
                            <div class="invoice-from">
                               <small>od</small>
                               <address class="m-t-5 m-b-5">
                                  <strong class="text-inverse">JAVO software s.r.o</strong><br>
                                  Ulice: Ve Smečkách, Nové Město (Praha 1), <br>
                                  Město: Praha<br>
                                  Č. p: 586/10<br>
                                  PSČ: 110 00
                               </address>
                            </div>
                            <div class="invoice-to">
                               <small>pro</small>
                               <address class="m-t-5 m-b-5">
                                  <strong class="text-inverse">'.$osfir.'</strong><br>
                                  Ulice: '.$ulice.'<br>
                                  Město: '.$mesto.'<br>
                                  Č. p: '.$cp.'<br>
                                  PSČ: '.$psc.'
                               </address>
                            </div>
                            <div class="invoice-date">
                               <small>Faktura vytvořena</small>
                               <div class="date text-inverse m-t-5">'.date('d.m.Y', $datum).'</div>
                            </div>
                         </div>
                         <!-- end invoice-header -->
                         <!-- begin invoice-content -->
                         <div class="invoice-content">
                            <!-- begin table-responsive -->
                            <div class="table-responsive">
                               <table class="table table-invoice">
                                  <thead>
                                     <tr>
                                        <th class="text-left">Podrobnosti zakázky</th>
                                        <th class="text-center" width="15%">Hodinová mzda</th>
                                        <th class="text-center" width="15%">Odprac. hodin</th>
                                        <th class="text-right" width="20%">SOUČET</th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                     <tr>
                                        <td>
                                           <span class="text-inverse">Odpracované hodiny pracovníka</span><br>
                                           <small>Započtena je každá hodina strávená na plnění zakázky</small>
                                        </td>
                                        <td class="text-center">'.$sazba.' Kč</td>
                                        <td class="text-center">'.$odpracHod.' h</td>
                                        <td class="text-right">'.$pracovnikCena.' Kč</td>
                                     </tr>
                                     <tr>
                                        <td>
                                           <span class="text-inverse">Cena za použité vybavení</span><br>
                                           <small>V této ceně je započítán veškerý poplatek za použité nářadí a techniku při vykonávání zakázky</small>
                                        </td>
                                        <td class="text-center">----</td>
                                        <td class="text-center">--</td>
                                        <td class="text-right">'.$totalZbozi.' Kč</td>
                                     </tr>
                                  </tbody>
                               </table>
                            </div>
                            <!-- end table-responsive -->
                            <!-- begin invoice-price -->
                            <div class="invoice-price">
                               <div class="invoice-price-left">
                                  <div class="invoice-price-row">
                                     <div class="sub-price">
                                        <small>Cena bez DPH</small>
                                        <span class="text-inverse">'.$cena.' Kč</span>
                                     </div>
                                     <div class="sub-price">
                                        <i class="fa fa-plus text-muted"></i>
                                     </div>
                                     <div class="sub-price">
                                        <small>DPH (21%)</small>
                                        <span class="text-inverse">'.$dph.' Kč</span>
                                     </div>
                                  </div>
                               </div>
                               <div class="invoice-price-right">
                                  <small>CENA S DPH</small> <span class="f-w-600">'.$total.' Kč</span>
                               </div>
                            </div>
                            <!-- end invoice-price -->
                         </div>
                         <!-- end invoice-content -->
                         <!-- begin invoice-note -->
                         <div class="invoice-note">
                            * Pokud máte nějaké otázky k fakturaci neváhejte a kontaktujte nás [JAVO software s.r.o, Tel.č: 111 222 333, Email: javosoftware@seznam.cz]
                         </div>
                         <!-- end invoice-note -->
                         <!-- begin invoice-footer -->
                         <div class="invoice-footer">
                            <p class="text-center m-b-5 f-w-600">
                               DĚKUJEME ZA VAŠI OBJEDNÁVKU
                            </p>
                            <p class="text-center">
                               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> Tel.č: 111 222 333</span>
                               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> javosoftware@seznam.cz</span>
                            </p>
                         </div>
                         </div>
                         <!-- end invoice-footer -->
                      </div>
                   </div>
    
                </div>
              </div>
              </div>';
     }
     else{
        header("Location: ../pages/ucet");
    	exit();
     }
?>
</body>
</html>
