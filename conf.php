<?php
$serverinimi = 'localhost';
$kasutajanimi = 'root';
$parool = '';
$andmebaasinimi = 'test';
$yhendus = new mysqli($serverinimi, $kasutajanimi,
    $parool, $andmebaasinimi);
$yhendus->set_charset('UTF8');
?>
