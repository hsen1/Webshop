<?php include_once '../konfiguracija.php';  ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php include_once '../predlosci/zaglavlje.php'; ?>
	</head>
	<body>
		<?php include_once '../predlosci/izbornik.php'; ?>
			<div class="row">
				<div class="grid-container">
					<div class="grid-x grid-margin-x">
						<div class="cell large-6 large-offset-3">
							<div class="primary callout">
					
							<h2 style="width: 100%; font-size: 1.5em; "><?php echo $naslovAplikacije ?></h2>
							<?php 
							if(isset($_GET["neuspio"])){
								echo "Pogrešno korisničko ime i/ili lozinka!";
							}
							
							if(isset($_GET["nemateOvlasti"])){
								echo "Morate se prvo logirati!";
							}
							
							if(isset($_GET["odlogiranSi"])){
								echo "Uspješno ste se odjavili!";
							}
							 ?>
							
							<form method="post" action="<?php echo $putanjaAPP;  ?>autorizacija.php">
								<label for="korisnik">Korisnik</label>
								<input type="text" name="korisnik" id="korisnik" placeholder="email" 
								value="<?php echo isset($_GET["korisnik"]) ? $_GET["korisnik"] : ""; ?>"/>
								<label for="lozinka">Lozinka</label>
								<input type="password" name="lozinka" id="lozinka" placeholder="lozinka"/>
								<input type="submit" class="button expanded" value="Prijava" />
							</form>
			
							</div>
							<ul class="ul" align="center">
								<li>Admin </li>
								<li>hrvojesen@gmail.com</li>
								<li>hrvoje</li>
								<li>Operater</li>
								<li>ivanivic@gmail.com</li>
								<li>ivan</li>
								<li>Kupac</li>
								<li>kupac1@gmail.com</li>
								<li>kupac1</li>
							</ul>
						</div>
					</div>
				</div>
				
			</div>
		<?php   include_once '../predlosci/podnozje.php'; ?>
		<?php	include_once '../predlosci/skripte.php'; ?>
	</body>
</html>
