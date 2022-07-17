<?php
	$celaURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // ERRORY PRO LOGIN SCRIPT
	if(strpos($celaURL,"login=uspesny") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste se přihlásil/a!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=nevyplnenepole") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Pro přihlášení zadejte e-mail a heslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=sqlerror") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Chyba! V tuto chvíli není možné provést tuto operaci!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=nespravneheslo") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Zadal/a jste špatné heslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=ucetneexistuje") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Účet s těmito údaji neexistuje!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO REGISTRACE SKRIPT
	else if(strpos($celaURL,"error=prazdnekolonky") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Pro úspěšnou registraci je třeba vyplnit všechna pole!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=gdprproblem") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Prosím potvrďte, že souhlasíte s GDPR pravidly!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=spatnezadanyemailajmeno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          E-mail, který se snažíte zadat není zapsán správně!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=spatnezadanyemail") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Prosím zadejte e-mail!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=spatnezadejmeno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Jméno, které se snažíte zadat není zapsané správně!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=heslanejsoustejna") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Zadaná hesla nejsou stejná!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=heslojekratke") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Zadaná heslo je příliš krátké! Minimální délka je 8 znaků
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=emailjezabrany") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Účet s touto e-mailovou adresou už existuje!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"registraceuspesna=success") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste se registroval/a
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO ZMEN TELEFON SCRIPT
	else if(strpos($celaURL,"zmenaTelcis==nevyplnenePole") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Prosím zadejte telefonní číslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"zmenaTelcis==spatnyVstup") == true || strpos($celaURL,"zmenaTelcis==problemDelka") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Telefonní  číslo, které se snažíte zadat má špatný tvar! (tvar: 111222333, bez mezer)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
    else if(strpos($celaURL,"menaTelcis==probehla") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste změnil/a své telefonní číslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO Zmen Mail SKRIPT
	else if(strpos($celaURL,"error==emailjezabrany") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          E-mailová adresa, kterou se snažíte použít je již obsazená!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"email==nevyplnen") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Zadejte e-mail!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"zmenaMail==probehla") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste změnil/a svůj e-mail!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO Zmen heslo SKRIPT
	else if(strpos($celaURL,"heslo==zmeneno") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste změnil/a své heslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=heslaNejsouStejna") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Hesla nejsou stejná!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=heslojekratke") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Hesla jsou příliš krátká! (min. 8 znaků)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=hesloPrazdne") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste heslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"error=hesloDvePrazdne") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste druhé heslo!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO ZAPIS UKOL SKRIPT
	else if(strpos($celaURL,"nazev==nevyplnen") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste název úkolu!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"osfir==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste osobu nebo firmu, pro kterou se úkol dělá!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"mesto==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste město, kde se úkol dělá!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"ulice==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste ulici, kde se úkol dělá!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"psc==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste PSČ!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"cp==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste číslo popisné!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"odkdy==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste od kdy se úkol má dělat!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"dokdy==nevyplneno") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste do kdy se úkol má udělat!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"zamestnanec==nevyplnen") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezadal/a jste zaměstnance, který bude úkol řešit!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO VYTVOR UCTENKU SKRIPT
	else if(strpos($celaURL,"sazba==error") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nenačetla se Vaše sazba! Kontaktujte vašeho nadřízeného!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"cas==nevyplnen") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nezapočítal/a jste odpracované hodiny! Zadejte počet hodin a potvrďte stisknutím tlačítka "přičíst k ceně"
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"cena==nevyplnena") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nenačetla se cena! Kontaktujte Vašeho nadřízeného!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO UPLOAD PROFILOVKY SKRIPT
	else if(strpos($celaURL,"uploadFoto=fotografiejeprilisvelka") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Fotografie, kterou se snažíte nahrát je příliš velká! (max 5mb)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"uploadFoto=problemprinahravani") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Při nahrávání fotografie nastal problém! Opakujte pokus
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"uploadFoto=spatnytypfotografie") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Soubor, který se snažíte nahrát má špatný typ! (povolené jsou jpg, jpeg, png)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"uploadFoto=uspesne") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste změnil/a svou profilovou fotografii!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"neopravnenyPristup") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Neoprávněný přístup!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO SMAZAT UKOL SKRIPT
	else if(strpos($celaURL,"smazaniUkolu=uspesne") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste smazal/a úkol!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO SMAZAT PROFILOVKU SKRIPT
	else if(strpos($celaURL,"smazaniFoto=uspesne") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste smazal/a profilovou fotografii!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ERRORY PRO PRIDEJ VEC SKRIPT
	else if(strpos($celaURL,"nazev==nezadan") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nebyl zadán název věci!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"pocet==nezadan") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nebyl zadán počet věci!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"cena==nezadana") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nebyla zadána cena věci (v Kč)!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"jednotka==nezadan") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Vyberte jednotku, ve které bude věc popisována!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"sekce==nezadan") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Vyberte sekci, do které se věc řadí!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"foto==velikost") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Fotografie je příliš velká! (max 5mb)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"foto==typ") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nepodporovaný typ souboru! (pouze jpeg,png,jpg)
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"vecPridana==uspesne") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste přidal/a věc do skladiště!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	// ODSTRANENI VECI ZE SKLADU
	else if(strpos($celaURL,"odstraneniVeci=uspesne") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste odstranil/a věc ze skladiště!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	//Objednat VECI SKRIPT
	else if(strpos($celaURL,"objednavka==uspesna") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Úspěšně jste objednal/a zboží!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"ukol==nevyplnen") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nebyl vybrán úkol, pro který si půjčujete věci!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"objednavka==nevyplnena") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nebyla vybrána věc ani úkol, ke kterým by jste mohl/a vytvořit objednávku!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	//Objednat EDIT VEC SKRIPT
	else if(strpos($celaURL,"editace==uspesna") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Editace proběhla úspěšně!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"foto=error") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Nastala chyba! Nelze nahrát fotografii!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	//sazba skript
	else if(strpos($celaURL,"nevyplnen==monter") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Sazba pro roli montér není vyplněna!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"nevyplnen==skladnik") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Sazba pro roli skladník není vyplněna!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"nevyplnen==sef") == true){
	    echo '
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Sazba pro roli šéf není vyplněna!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"ban==uspesny") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Uživatel byl úspěšně zabanován!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"unb==uspesny") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Uživatel byl úspěšně unbanován!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"smz==uspesny") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Uživatel byl úspěšně smazán!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"obj==smazana") == true){
	    echo '
	    <div class="alert alert-success alert-dismissible fade show" role="alert">
          Objednávka byla úspěšně smazána!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
	else if(strpos($celaURL,"ban==aktivni") == true){
	    echo '
	    <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Váš účet je v momentální chvíli zabanován! Nelze se přihlásit!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
	}
?>