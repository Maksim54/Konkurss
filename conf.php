<?php
$serverinimi='localhost';
$kasutajanimi='root';
$parool='';
$andmebaasinimi='loomad';
$yhendus=new mysqli($serverinimi, $kasutajanimi,
    $parool, $andmebaasinimi);
$yhendus->set_charset('UTF8');
/*
   create table konkurss(
    id int PRIMARY KEY AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaar text,
    avalik int DEFAULT 1
    )
*/
?>