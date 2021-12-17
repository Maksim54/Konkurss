<?php
require_once ('conf.php');
global $yhendus;

session_start();
if (!isset($_SESSION['tuvastamine'])){//!-не / ne
    header('Location: LoginABkonkurss.php');
    exit();

}

// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

// nimi näitamine avalik=1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['avamine']);
    $kask->execute();
}
// nimi näitamine avalik=0 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET avalik=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();
}
// kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $kask->bind_param("i", $_REQUEST['kustuta']);
    $kask->execute();
}


if(isset($_REQUEST['kustutakomment'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET kommentaar='' WHERE id=?");
    $kask->bind_param("i", $_REQUEST['kustutakomment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}


?>


<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurssi halduse leht </title>
    <link rel="stylesheet" type="text/css" href="konkstyle.css">
</head>
<body>
<div>
    <p id="sessiakto"><?=$_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logoutkonkurss.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
</div>
<nav>
    <ul>
        <li><a href="lisamine.php">Fotokonkursi lisamine</a></li>
        <li><a href="konkurss.php">Kasutaja leht</a></li>
        <li><a href="https://github.com/Maksim54/Konkurss">GitHub</a></li>
    </ul>
</nav>
<h1>Fotokonkurssi halduseleht</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi, pilt, kommentaar, lisamisaeg, punktid, avalik FROM konkurss");
$kask->bind_result($id, $nimi, $pilt, $kommentaar, $aeg, $punktid, $avalik);
$kask->execute();
echo "<table><tr>
    <th></th>
    <th></th>
    <th></th>
    <th>Nimi</th>
    <th>Pilt</th>
    <th>Lisamisaeg</th>
    <th>Punktid</th>
    <th>Punktid nulliks</th>
    <th>Kommentaar</th>
    <th>Kustuta kommentaar</th>";

while($kask->fetch()){
    $kontroll='"Kas olete kindel, et kustutate?"';
    echo "<tr>";
    echo "<td><a href='?kustuta=$id' onclick='return confirm($kontroll)'>Kustuta</a></td>";
    // Peida-näita
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if ($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    echo"<td>$seisund</td>";
    echo"<td><a href='?$param=$id'>$avatekst</a></td>";


    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a></td>";
    echo "<td>".nl2br($kommentaar)."</td>";

    echo "<td><a href='?kustutakomment=$id'>Kustuta komment</a></td>";




    echo "</tr>";


}
echo "<table>";
?>


</body>
</html>


