<?php

include_once '../../konfiguracija.php'; provjeraLogin();


$izraz=$veza->prepare("insert into proizvod(naziv, opis, cijena, kolicina, brand, garancija, dobavljac_FK, kategorija_FK) values ('', '', '', '', default, default, 1, 1)");
$izraz->execute();
$zadnji = $veza->lastInsertId();


header("location: promjena.php?sifra=" . $zadnji);

