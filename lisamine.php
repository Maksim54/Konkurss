<?php
require_once ('conf.php');
global $yhendus;

//nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask=$yhendus->prepare("INSERT INTO konkurss(nimi, pilt, lisamisaeg)VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>

<!Doctype html>
<html lang="et">
<head>
    <title>Lisamine</title>
    <link rel="stylesheet" type="text/css" href="konkstyle.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="konkurss.php">Tagasi</a></li>
        <li><a href="link">GitHub</a></li>
    </ul>
</nav>
<h1>Fotokonkursi lisamine</h1>

<form action="?">
    <input type="text" name="nimi" placeholder="Uus nimi">
    <br><br>
    <textarea name="pilt" placeholder="Pildi linki aadress"></textarea>
    <br>
    <input type="submit" id="lisa" value="Lisa">
</form>
</body>
</html>