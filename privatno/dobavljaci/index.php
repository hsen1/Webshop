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
								<input type="text" placeholder="dio naziva" name="uvjet" 
								value="<?php echo $uvjet; ?>"/>	
							</form>
						</div>
						<?php 
							$uvjetUpit="%" . $uvjet . "%";
							$izraz=$veza->prepare("select count(*) from dobavljac where naziv like :uvjet");
							$izraz->execute(array("uvjet"=>$uvjetUpit));
							$ukupnoDobavljaca=$izraz->fetchColumn();
							$ukupnoStranica=ceil($ukupnoDobavljaca/$rezultataPoStranici);
							if($stranica>$ukupnoStranica){
								$stranica=$ukupnoStranica;
							}					
						?>
						<div class="cell large-2" style="text-align: center;">Ukupno 
							<?php echo $ukupnoDobavljaca; ?><br />
						</div>
						<div class="large-auto cell">
							<a href="unos.php" class="success button expanded"><i title="Dodaj" class="step fi-page-add size-48"></i> Dodaj</a>
						</div>
					</div>
				</div>
				<div>
					<?php include '../../predlosci/paginator.php'; ?>
				</div>
					<table>
						<thead>
							<tr>
								<th><i title="OIB" class="step fi-list-number size-48"></i> OIB</th>
								<th><i title="Naziv" class="step fi-folder size-48"></i> Naziv</th>
								<th><i title="Žiroračun" class="step fi-euro size-48"></i> Žiroračun</th>
								<th><i title="Email" class="step fi-mail size-48"></i> Email</th>
								<th><i title="Adresa" class="step fi-address-book size-48"></i> Adresa</th>
								<th><i title="Mjesto" class="step fi-mountains size-48"></i> Mjesto</th>
								<th><i title="Poštanski broj" class="step fi-map size-48"></i> Poštanski broj</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$izraz = $veza->prepare("select * from dobavljac
							where naziv like :uvjet limit " . (($rezultataPoStranici*$stranica)-$rezultataPoStranici) . ", " . $rezultataPoStranici);
							$uvjet="%" . $uvjet . "%";
							$izraz->execute(array("uvjet"=>$uvjet));
							$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
							foreach ($rezultati as $red) :
							?>
							<tr>
								<td><?php echo $red->oib; ?></td>
								<td><?php echo $red->naziv; ?></td>
								<td><?php echo $red->ziroracun; ?></td>
								<td><?php echo $red->email; ?></td>
								<td><?php echo $red->adresa; ?></td>
								<td><?php echo $red->mjesto; ?></td>
								<td><?php echo $red->postanskiBroj; ?></td>
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
