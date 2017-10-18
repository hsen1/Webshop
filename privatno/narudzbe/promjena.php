<?php include_once '../../konfiguracija.php'; provjeraLogin(); 

if(isset($_GET["sifra"])){
	$izraz=$veza->prepare("select * from narudzba where sifra=:sifra");
	$izraz->execute(array("sifra"=>$_GET["sifra"]));
	$narudzba = $izraz->fetch(PDO::FETCH_OBJ);
}

if(isset($_POST["promjena"])){
	
	//implementirati kontrole
	
	$izraz=$veza->prepare("update narudzba set brojNarudzbe=:brojNarudzbe, datum=:datum, status=:status, 
	napomena=:napomena, dostava_FK=:dostava_FK, kupac_FK=:kupac_FK where sifra=:sifra");
	$izraz->execute(array(
	"brojNarudzbe"=>$_POST["brojNarudzbe"],
	"datum"=>$_POST["datum"],
	"status"=>$_POST["status"],
	"napomena"=>$_POST["napomena"],
	"dostava_FK"=>$_POST["dostava_FK"],
	"kupac_FK"=>$_POST["kupac_FK"],
	"sifra"=>$_POST["sifra"] ));
	
	header("location: index.php");
}

if(isset($_POST["odustani"])){
	if($_POST["status"]==""){
		$izraz=$veza->prepare("delete from narudzba where sifra=:sifra");
		$izraz->execute(array("sifra"=>$_POST["sifra"] ));
	}

	header("location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../../predlosci/izbornik.php'; ?>
		<div class="row">
			<div class="grid-x grid-padding-x">
				<div class="cell large-4 large-offset-4">
					<form method="POST">
						<fieldset class="fieldset">
							<legend>Uneseni podaci</legend>
							
							<label for="brojNarudzbe">Broj narudžbe</label>
							<input name="brojNarudzbe" id="brojNarudzbe" value="<?php echo $narudzba->brojNarudzbe; ?>" type="text" />
							
							<label for="datum">Datum</label>
							<input name="datum" id="datum" value="<?php echo date("Y-m-d",strtotime($narudzba->datum)); ?>" type="date"/>
							
							<label for="status">Status</label>
							<input name="status" id="status" value="<?php echo $narudzba->status; ?>" type="text" />
							<!--
							<select name="status">
								<?php if($narudzba->status==""): ?>
										<option value="0">Odaberite dostavu</option>
										
										<?php
										endif;
										?>
								<option value="1">u obradi</option>
								<option value="2">u dostavi</option>
								<option value="3">isporučeno</option>
							</select>
							-->
							<label for="napomena">Napomena</label>
							<input name="napomena" id="napomena" value="<?php echo $narudzba->napomena; ?>" type="text" />
							
							<label for="dostava_FK">Dostava</label>
							<select name="dostava_FK">
										<?php if($narudzba->status==""): ?>
										<option value="0">Odaberite dostavu</option>
										
										<?php
										endif;
										 
										$izraz=$veza->prepare("select sifra, vrsta from dostava order by vrsta");
										$izraz->execute();
										$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
										foreach ($rezultati as $red) :
										?>
										<option <?php 
										if($narudzba->status!="" && $narudzba->dostava_FK == $red->sifra){
											echo " selected=\"selected\" ";
										}
										
										?> value="<?php echo $red->sifra ?>"><?php echo $red->vrsta ?></option>
										<?php endforeach; ?>
							</select>

							<label for="kupac_FK">Kupac</label>
							<select name="kupac_FK">
										<?php if($narudzba->status==""): ?>
										<option value="0">Odaberite kupca</option>
										
										<?php
										endif;
										
										$izraz=$veza->prepare("select sifra, ime, prezime from kupac order by ime, prezime");
										$izraz->execute();
										$rezultati=$izraz->fetchAll(PDO::FETCH_OBJ);
										foreach ($rezultati as $red) :
										?>
										<option <?php 
										
										if($narudzba->status!="" && $narudzba->kupac_FK == $red->sifra){
											echo " selected=\"selected\" ";
										}
										
										?> value="<?php echo $red->sifra ?>"><?php echo $red->ime?> <?php echo $red->prezime?></option>
										<?php endforeach; ?>
							</select>
							
							<input name="promjena" type="submit" class="button expanded" value="<?php 
							if($narudzba->status==""){
								echo "Dodaj novi";
							}else{
								echo "Promjeni";
							}
							?>"/>
							<input type="hidden" name="sifra" value="<?php echo $narudzba->sifra; ?>" />
							
							<input name="odustani" type="submit" class="alert button expanded" value="Odustani"/>
						</fieldset>
					</form>	
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
