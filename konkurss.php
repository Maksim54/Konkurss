<?php
require_once ('conf.php');
global $yhendus;
// punktide lisamine UPDATE

session_start();
if (!isset($_SESSION['tuvastamine'])){
    header('Location: LoginAB.php');
    exit();

}

if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
//uue kommentaari lisamine
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET kommentaar=CONCAT(kommentaar, ?) WHERE id=?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask->bind_param("si", $kommentlisa, $_REQUEST['uus_komment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurss</title>
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
        <?php if($_SESSION['onAdmin']==1) { ?>
        <li><a href="lisamine.php">Fotokonkursi lisamine</a></li>
    <li><a href="haldus.php">Admin leht</a></li>
        <?php } ?>

        <li><a href="https://github.com/Maksim54/Konkurss">GitHub</a></li>
    </ul>
</nav>
<h1>Fotokonkurss "Telefonid"</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi, pilt, kommentaar, punktid FROM konkurss WHERE avalik=1");
$kask->bind_result($id, $nimi, $pilt, $kommentaar, $punktid);
$kask->execute();

echo "<table>";
if($_SESSION['onAdmin']==0) {
    echo "<tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Kommentaarid</th>
        <th>Lisa kommentaar</th>
        <th>Punktid</th>
        <th>Lisa punktid</th></tr>";
    }
else{
    echo "<tr>
    <th>Nimi</th>
    <th>Pilt</th>
    <th>Kommentaarid</th>
    <th>Punktid</th>
    </tr>";
    }
while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>".nl2br($kommentaar)."</td>";
    if($_SESSION['onAdmin']==0) {
        echo "<td>
    <form action='?'>
        <input type='hidden' name='uus_komment' value='$id'>
        <input type='text' name='komment'>
        <input type='submit' value='OK'>
    </form></td>";
    }

    echo "<td>$punktid</td>";
    if($_SESSION['onAdmin']==0) {
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    }
    echo "</tr>";
    }
    echo "<table>";
    ?>

</body>
</html>

