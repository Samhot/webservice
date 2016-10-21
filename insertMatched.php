<?php
$servername = "164.132.195.67";
$username = "root";
$password = "toma66/moii";
$dbname = "mybookingtraining";
    $idAdvert=$_GET["idAdvert"];
    $idCandidate=$_GET["idCandidate"];
    $type=$_GET["Type"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `mybookingtraining`.`Matched` (`idMatch`, `idAdvert`, `idCandidate`, `Type`) VALUES (NULL, $idAdvert, $idCandidate, $type)";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
