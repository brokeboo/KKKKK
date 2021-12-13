<?php
require_once ('conf.php');
global $yhendus;
// punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}


?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurss</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav>
    <a href="haldus.php">Admin leht</a>
    <a href="konkurs.php">Kasutaja leht</a>
</nav>
<h1>Fotokonkurss ""</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("
SELECT id, nimi, pilt, lisamisaeg, punktid FROM konkurss WHERE avalik=1");
$kask->bind_result($id, $nimi, $pilt, $aeg, $punktid);
$kask->execute();
echo "<table><tr><th>Nimi</th>
<th>Pilt</th>
<th>Lisamisaeg</th>
<th>Punktid</th></tr>";

while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    echo "</tr>";
}
echo "<table>";
?>

</body>
</html>

