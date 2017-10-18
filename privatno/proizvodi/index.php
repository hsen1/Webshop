<?php include_once '../../konfiguracija.php';  provjeraLogin(); ?>
<?php 
$uvjet = isset($_GET["uvjet"]) ? $_GET["uvjet"] : "";
$stranica=1;
if(isset($_GET["stranica"])){
	if ($_GET["stranica"]>0){
		$stranica=$_GET["stranica"];
	}
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
			<div class="callout">
				<div class="row">
					<div class="grid-x grid-padding-x">
						<div class="large-auto cell">
							<form method="GET">
								<input type="text" placeholder="dio naziva" name="uvjet" value="<?php echo $uvjet; ?>"/>	
							</form>
						</div>
						<?php 
							$uvjetUpit="%" . $uvjet . "%";
							$izraz=$veza->prepare("select count(*) from proizvod 
							inner join dobavljac on dobavljac.sifra=proizvod.dobavljac_FK
							inner join kategorija on kategorija.sifra=proizvod.kategorija_FK
							where concat (proizvod.naziv, dobavljac.naziv, kategorija.naziv) like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoProizvoda=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoProizvoda/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
					?>
						<div class="cell large-2" style="text-align: center;">Ukupno <?php 
						echo $ukupnoProizvoda;
						?><br />
						</div>
						
						<div class="large-auto cell">
							<a href="unos.php" class="success button expanded"><i title="Dodaj" class="step fi-page-add size-48"></i> Dodaj</a></th>
						</div>
					</div>
				</div>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
					<table>
						<thead>
							<tr>
								<th><i title="Naziv" class="step fi-camera size-48"></i> Naziv</th>
								<th><i title="Opis" class="step fi-link size-48"></i> Opis</th>
								<th><i title="Cijena" class="step fi-camera size-48"></i> Cijena</th>
								<th><i title="Brand" class="step fi-camera size-48"></i> Brand</th>
								<th><i title="Garancija" class="step fi-camera size-48"></i> Garancija</th>
								<th><i title="Količina" class="step fi-camera size-48"></i> Količina na stanju</th>
								<th><i title="Dobavljač" class="step fi-camera size-48"></i> Dobavljač</th>
								<th><i title="Kategorija" class="step fi-folder size-48"></i> Kategorija</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$izraz = $veza->prepare("select proizvod.sifra, proizvod.naziv, proizvod.opis, 
							proizvod.cijena, proizvod.brand, proizvod.garancija, proizvod.kolicina, 
							dobavljac.naziv as dobavljac, kategorija.naziv as kategorija
							from proizvod 
							inner join dobavljac on dobavljac.sifra=proizvod.dobavljac_FK
							inner join kategorija on kategorija.sifra=proizvod.kategorija_FK
							where concat (proizvod.naziv, dobavljac.naziv, kategorija.naziv) like :uvjet limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->naziv; ?></td>
								<td><?php echo $red->opis; ?></td>
								<td><?php echo $red->cijena; ?></td>
								<td><?php echo $red->brand; ?></td>
								<td><?php echo $red->garancija; ?></td>
								<td><?php echo $red->kolicina; ?></td>
								<td><?php echo $red->dobavljac; ?></td>
								<td><?php echo $red->kategorija; ?></td>
								<td>
									<a href="promjena.php?sifra=<?php echo $red->sifra;
									if(isset($_GET["uvjet"])){
										echo "&uvjet=" . $_GET["uvjet"];
									}?>"><i title="Promjena" class="step fi-page-edit size-48"></i> Izmjeni</a> 
									
									<a href="brisanje.php?sifra=<?php echo $red->sifra;
										if(isset($_GET["uvjet"])){
										echo "&uvjet=" . $_GET["uvjet"];
									}?>"><i title="Obriši" class="step fi-page-delete size-48"></i> Obriši</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
			</div>
		</div>
		<?php	include_once '../../predlosci/podnozje.php'; ?>
		<?php	include_once '../../predlosci/skripte.php'; ?>
		
	</body>
</html>
