<?php
session_start();
include_once 'dtb.php';

$nazevHledany=$_POST['textHledaneVeci'];

if(isset($_POST['vyhledejPoleVec'])){
  if(empty($nazevHledany)){
    header("Location: ../pages/skladiste");
    exit();	//dokud neopravi chybu, kod pod timto ifem se neprovede
  }
  else {
    $_SESSION['vyhledano']=1;
    $_SESSION['hledanaVec']=$nazevHledany;
    header("Location: ../pages/skladiste?".$nazevHledany);
    exit();
  }
}
