drop database if exists webshop;
create database webshop default character set utf8;
use webshop;

#byethost
#alter database default character set utf8;

#tablice
create table operater(
sifra			int not null primary key auto_increment,
ime 			varchar(50) not null,
prezime 		varchar(50) not null,
email 			varchar(50) not null,
lozinka			char(32) not null,
uloga			varchar(50) not null
);

create table kupac(
sifra			int (6) not null primary key auto_increment,
ime				varchar (50) not null,
prezime			varchar (50) not null,
email			varchar (100) not null,
lozinka			char (32) not null,
adresa			varchar (255) not null,
mjesto			varchar (255) not null,
postanskiBroj	int (5) not null,
uloga			varchar(50) not null default 'kupac'
);

create table proizvod(
sifra			int (6) not null primary key auto_increment,
naziv			varchar (50) not null,
opis			varchar (1000) not null,
cijena			decimal (18,2) not null,
brand			varchar (50),
garancija		int (2) default 0,
kolicina		int (4) not null default 0,
dobavljac_FK	int (6) not null,
kategorija_FK	int (6) not null
);

create table narudzba(
sifra			int (6) not null primary key auto_increment,
brojNarudzbe	varchar (20) not null,
datum			datetime not null,
status			varchar (15) not null,
napomena		varchar (200),
dostava_FK		int (6) not null,
kupac_FK		int (6) not null
);

create table dobavljac(
sifra			int (6) not null primary key auto_increment,
oib				char (11) not null,
naziv			varchar (100) not null,
ziroracun		varchar (50) not null,
email			varchar (100),
adresa			varchar (255),
mjesto			varchar (255),
postanskiBroj	int (5)
);

create table kosarica(
kolicina		int (4) not null,
cijena			decimal (18,2) not null,
proizvod_FK		int (6) not null,
narudzba_FK		int (6) not null,
primary key (proizvod_FK, narudzba_FK)
);

create table kategorija(
sifra			int (6) primary key auto_increment,
naziv			varchar (50) not null,
slika			varchar (255),
opis			varchar (50)
);

create table dostava(
sifra			int (6) primary key auto_increment,
vrsta			varchar (20) not null,
cijena			decimal (18,2) not null
);

#alteri
alter table proizvod add foreign key (dobavljac_FK) references dobavljac(sifra);
alter table proizvod add foreign key (kategorija_FK) references kategorija(sifra);

alter table narudzba add foreign key (kupac_FK) references kupac(sifra);
alter table narudzba add foreign key (dostava_FK) references dostava(sifra);

alter table kosarica add foreign key (proizvod_FK) references proizvod(sifra);
alter table kosarica add foreign key (narudzba_FK) references narudzba(sifra);

#inserti
insert into operater values 
('', 'Hrvoje', 'Šen', 'hrvojesen@gmail.com', md5('hrvoje'), 'admin'),
('', 'Ivan', 'Ivić', 'ivanivic@gmail.com', md5('ivan'), 'korisnik');

insert into dobavljac values
('', 12345678911, 'Tvrtka 1 d.o.o.', 'HR2125000091111111111', '', '', '', ''),
('', 12345678912, 'Tvrtka 2 d.o.o.', 'HR2523400091111111112', 'tvrtka2@gmail.com', 'Stjepana Radića 20', 'Zagreb', 10000),
('', 12345678913, 'Tvrtka 3 d.o.o.', 'HR4923600001111111113', '', 'Buzinski Prilaz 10', 'Zagreb', 10010);

insert into kategorija values
('', 'Procesor', '', ''),
('', 'Matična ploča', '', ''),
('', 'Memorija', '', '');

insert into proizvod values
('', 'Proizvod 1', 'proizvod 1', 1500.00, '', 24, 10, 1, 1),
('', 'Proizvod 2', 'proizvod 2', 500.00, '', 12, 20, 1, 2),
('', 'Proizvod 3', 'proizvod 3', 280.00, '', 6, 48, 2, 2),
('', 'Proizvod 4', 'proizvod 4', 195.00, '', 36, 11, 3, 3),
('', 'Proizvod 5', 'proizvod 5', 2900.00, '', '', 3, 3, 1);

insert into kupac values
('', 'Ivan', 'Marić', 'kupac1@gmail.com', md5('kupac1'), 'Vladimira Nazora 117', 'Đakovo', 31400, default),
('', 'Marko', 'Živković', 'kupac2@gmail.com', md5('kupac2'), 'Marka Marulića 18', 'Osijek', 31000, default),
('', 'Natko', 'Đikić', 'kupac3@gmail.com', md5('kupac3'), 'Vladimira Nazora 10', 'Zagreb', 10000, default);

insert into dostava values
('', 'besplatna', 0.00),
('', 'do 2000,00 kn', 40.00);

insert into narudzba values
('', '1/2017', '2017-07-12', 'u obradi', '', 1, 2),
('', '2/2017', '2017-06-18', 'isporučeno', '', 2, 3);

insert into kosarica values
(1, 2900.00, 5, 1),
(1, 500.00, 2, 2),
(2, 390.00, 4, 2);
