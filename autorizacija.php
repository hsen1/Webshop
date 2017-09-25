<?php
include_once 'konfiguracija.php';
if(!isset($_POST["korisnik"]) || !isset($_POST["korisnik"])){
	header("location: " . $putanjaAPP . "index.php");
}

//spajanje na bazu
$izraz=$veza->prepare("select * from operater where email=:email and lozinka=md5(:lozinka)");
$izraz->execute(array("email"=>$_POST["korisnik"], "lozinka" =>$_POST["lozinka"]));
$operater = $izraz->fetch(PDO::FETCH_OBJ);
if($operater!=null){
	//logiranog operatera postavljam u Session
	$_SESSION["logiran"]=$operater;
	header("location: " . $putanjaAPP . "privatno/nadzornaPloca.php");
	exit;
}else{
	//nisi logiran
	header("location: " . $putanjaAPP . "javno/login.php?neuspio&korisnik=" . $_POST["korisnik"]);
}

if(!isset($_POST["kupac"]) || !isset($_POST["kupac"])){
	header("location: " . $putanjaAPP . "index.php");
}

//spajanje na bazu
$izraz=$veza->prepare("select * from kupac where email=:email and lozinka=md5(:lozinka)");
$izraz->execute(array("email"=>$_POST["korisnik"], "lozinka" =>$_POST["lozinka"]));
$kupac = $izraz->fetch(PDO::FETCH_OBJ);
if($kupac!=null){
	//logiranog kupca postavljam u Session
	$_SESSION["logiran"]=$kupac;
	header("location: " . $putanjaAPP . "privatno/nadzornaPloca.php");
	exit;
}else{
	//nisi logiran
	header("location: " . $putanjaAPP . "javno/login.php?neuspio&korisnik=" . $_POST["kupac"]);
}