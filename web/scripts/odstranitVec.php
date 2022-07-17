<?php
	session_start();
	include_once 'dtb.php';
	$idVec=$_POST['idVecHidden'];

	if(isset($_POST['odstranitVec'])){
	 $sql = "DELETE FROM skladiste WHERE id=?;";
	 $stmt = mysqli_stmt_init($pripojeni);

		 if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../pages/skladiste?error=sqlerror");
			exit();
		 }else{
			//********************************************************hledani a odstraneni nahledove fotografie
			$sqla="SELECT * FROM skladiste WHERE id=$idVec;";
			$vysa= mysqli_query($pripojeni,$sqla);
			$rowa = mysqli_fetch_assoc($vysa);
			if($rowa['foto']==1)
			{
				$jmenoFoto="../photos/items/item".$idVec."*";
			  $fotoinfo=glob($jmenoFoto);
			  $fotoext=explode(".",$fotoinfo[0]);
			  $fotoKonc=$fotoext[3];

				$foto = "../photos/items/item".$idVec.".".$fotoKonc;
				if(!unlink($foto)){
				}

			}
			mysqli_stmt_bind_param($stmt,"s",$idVec);
			mysqli_stmt_execute($stmt);
			header("Location: ../pages/skladiste?odstraneniVeci=uspesne");
			exit();
		 }
	}
?>
