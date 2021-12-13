<?php
require_once ("conf.php");
global $yhendus;
//punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET punktid=punktid=0 WHERE id=?");
    $kask->bind_param("i",$_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi lisamine konkurssi
if(!empty($_REQUEST['pilt'])){
    $kask=$yhendus->prepare("INSERT INTO konkurss(nimi,pilt,lisamisaeg)VALUES(?,?,NOW())");
    $kask->bind_param("ss",$_REQUEST['nimi'],$_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi näitamine avalik=1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i",$_REQUEST['avamine']);
    $kask->execute();
}

//nimi peitmine avalik=0 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET avalik=0 WHERE id=?");
    $kask->bind_param("i",$_REQUEST['peitmine']);
    $kask->execute();
}
//kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("DELETE from konkurss WHERE id=?");
    $kask->bind_param("i",$_REQUEST['kustuta']);

    $kask->execute();
}

?>
<!Doctype html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="konkstyle.css">
    <title>Fotokonkurssi halduse leht</title>
</head>
<body>
<h1>
    Fotokonkurssi halduse leht "Telefonid"
</h1>
<?php
//tabel konkurss sisu näitamine
$kask=$yhendus->prepare("Select id,nimi,pilt,lisamisaeg,punktid,avalik from konkurss");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid,$avalik);
$kask->execute();
echo "<table><tr><td>Nimi</td><td>Pilt</td><td>Lisamisaeg</td><td>Punktid</td></tr>";

while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<tr><td><img src='$pilt' alt='pilt'></td>";
    echo "<tr><td>$aeg</td>";
    echo "<tr><td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a></td>";
    // peida-näita
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    echo "<td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";

    echo "</tr>";
}

echo "<table>";

?>

<h2>
    Uue pilti lisamine on konkurssi
</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="uus nimi">
    <br>
    <textarea name="pilt">pildi linki adress</textarea>
    <br>
    <input type="submit" value="Add">
</form>
<br>
<nav>
    <a href="haldus.php">Admin leht</a>
    <a href="konkurss.php">User leht</a>
</nav>
</body>
</html>