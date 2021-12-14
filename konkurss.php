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
//uue kommentaari lisamine
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET kommentaar=CONCAT(kommentaar,?) WHERE id=?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask->bind_param("si",$kommentlisa,$_REQUEST['uus_komment']);
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
<div>
    <form action="logivalja.php" method="post">
        <input type="submit" value="log out" name="logout">
    </form>
</div>
<h1>
    Fotokonkurss "Telefonid"
</h1>
<?php
//tabel konkurss sisu näitamine
$kask=$yhendus->prepare("Select id,nimi,pilt,kommentaar,punktid from konkurss WHERE avalik=1");
$kask->bind_result($id,$nimi,$pilt,$kommentaar,$punktid);
$kask->execute();
echo "<table><tr><td>Nimi</td><td>Pilt</td><td>Kommentaarid</td><td>Lisa kommentaarid</td><td>Punktid</td></tr>";
while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>".nl2br($kommentaar)."</td>";
    echo "<td>
    <form action='?'>
    <input type='hidden' name='uus_komment' value='$id'>
    <input type='text' name='komment'>
    <input type='submit' value='OK'>
</form></td>
<br>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1 punkt</a></td>";
    echo "</tr>";
}
echo "<table>";
?>
<br>
<nav>
    <a href="haldus.php">Admin leht</a>
    <br>
    <a href="konkurss.php">User leht</a>
    <br>
    <a href="https://github.com/Maksim54/Konkurss">Link to github</a>
</nav>
</body>
</html>