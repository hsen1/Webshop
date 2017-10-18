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
							$izraz=$veza->prepare("select count(*) from narudzba 
							inner join kupac on kupac.sifra=narudzba.kupac_FK
							inner join dostava on dostava.sifra=narudzba.dostava_FK
							where concat (kupac.ime, kupac.prezime, narudzba.brojNarudzbe) like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoNarudzbi=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoNarudzbi/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
					?>
						<div class="cell large-2" style="text-align: center;">Ukupno <?php 
						echo $ukupnoNarudzbi;
						?><br />
						</div>
						
						<div class="large-auto cell">
							<a href="unos.php" class="success button expanded"><i title="Dodaj" class="step fi-page-add size-48"></i> Dodaj</a></th>
						</div>
					</div>
					
					<div class="hide-for-large">
						<?php include '../../predlosci/paginator.php'; ?>
					</div>
				</div>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
					<table>
						<thead>
							<tr>
								<th><i title="Broj narudžbe" class="step fi-camera size-48"></i> Broj narudžbe</th>
								<th><i title="Datum" class="step fi-link size-48"></i> Datum</th>
								<th><i title="Status" class="step fi-camera size-48"></i> Status</th>
								<th><i title="Napomena" class="step fi-camera size-48"></i> Napomena</th>
								<th><i title="Ime" class="step fi-camera size-48"></i> Ime</th>
								<th><i title="Prezime" class="step fi-camera size-48"></i> Prezime</th>
								<th><i title="Dostava" class="step fi-camera size-48"></i> Dostava</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$izraz = $veza->prepare("select narudzba.sifra, narudzba.brojNarudzbe as broj, narudzba.datum, narudzba.status, 
							narudzba.napomena, kupac.ime as ime, kupac.prezime as prezime, dostava.vrsta as dostava
							from narudzba 
							inner join kupac on kupac.sifra=narudzba.kupac_FK
							inner join dostava on dostava.sifra=narudzba.dostava_FK
							where concat (kupac.ime, kupac.prezime, narudzba.brojNarudzbe) like :uvjet limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->broj; ?></td>
								<td><?php echo $red->datum; ?></td>
								<td><?php echo $red->status; ?></td>
								<td><?php echo $red->napomena; ?></td>
								<td><?php echo $red->ime; ?></td>
								<td><?php echo $red->prezime; ?></td>
								<td><?php echo $red->dostava; ?></td>
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
