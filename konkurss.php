<?php
require_once ("conf.php");
global $yhendus;
//punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param("i",$_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!Doctype html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="konkstyle.css">
    <title>Fotokonkurss</title>
</head>
<body>
<h1>
    Fotokonkurss "Telefonid"
</h1>
<?php
//tabel konkurss sisu näitamine
$kask=$yhendus->prepare("Select id,nimi,pilt,lisamisaeg,punktid from konkurss WHERE avalik=1");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid);
$kask->execute();
echo "<table><tr><td>Nimi</td><td>Pilt</td><td>Lisamisaeg</td><td>Punktid</td></tr>";

while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<tr><td><img src='$pilt' alt='pilt'></td>";
    echo "<tr><td>$aeg</td>";
    echo "<tr><td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1 punkt</a></td>";
    echo "</tr>";
}

echo "<table>";

?>
<br>
<nav>
    <a href="haldus.php">Admin leht</a>
    <a href="konkurss.php">User leht</a>
</nav>
</body>
</html>