<?php
require_once ('conf.php');
global $yhendus;
// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask=$yhendus->prepare("
INSERT INTO konkurss(nimi, pilt, lisamisaeg)
VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi näitamine avalik=1 update
if(isset($_REQUEST['avalik'])){
    $kask=$yhendus->prepare("UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['avalik']);
    $kask->execute();
}
//nimi näitamine avalik=0 update
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



?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurssi halduse leht </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav>
    <a href="haldus.php">Admin leht</a>
    <a href="konkurs.php">Kasutaja leht</a>
</nav>
<h1>Fotokonkurssi halduseleht</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("
SELECT id, nimi, pilt, lisamisaeg, punktid, avalik FROM konkurss");
$kask->bind_result($id, $nimi, $pilt, $aeg, $punktid, $avalik);
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
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a></td>";
    //peida-näita
    $avatekst="Ava";
    $param="avalik";
    $seisund="Peidetud";
    if ($avalik==1){
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
<h2>Uue pilti lisamine konkurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="Uus nimi">
    <br>
    <textarea name="pilt">Pildi linki aadress</textarea>
    <br>
    <input type="submit" value="Lisa">
</form>

</body>
</html>



