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
//
if (isset($_REQUEST['kommentaar'])){
    $kask=$yhendus->prepare("UPDATE konkurss set kommentaar=' ' where id=?");
    $kask->bind_param("i",$_REQUEST['kommentaar']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!Doctype html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="konkstyle.css">
    <title>Fotokonkurssi halduse leht</title>
</head>
<body>
<div>
    <form action="logivalja.php" method="post">
        <input type="submit" value="log out" name="logout">
    </form>
</div>
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
    echo "<tr>";
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a></td>";
    echo"<td><a href='?kommentaar=$id'>Kommentaride nulliks</a></td>";
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
    <br>
    <a href="konkurss.php">User leht</a>
    <br>
    <a href="https://github.com/Maksim54/Konkurss">Link to github</a>
</nav>
</body>
</html>