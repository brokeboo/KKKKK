<?php
$servernimi='localhost';
$kasutajanimi='ilya1';
$parool='Ilyuxa2005';
$andmebaasinimi='antonov20';
$yhendus=new mysqli($servernimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset('UTF8');
/*CREATE TABLE konkurss(
    id int primary key AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int default 0,
    kommentaar text DEFAULT ' ',
    avalik int DEFAULT 1)*/
?>