<?php
session_start();
if (!isset($_SESSION['tuvastamine'])){
    header('Location: loginABkonkurss.php');
    exit();

}
if (isset($_POST['logout'])){
    session_destroy();
    //aadressi reas avatakse login.php fail
    header('Location: loginABkonkurss.php');
    exit();//vexod iz if
}
?>
