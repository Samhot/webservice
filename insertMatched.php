<?php $hostname = '164.132.195.67'; /*** mysql username ***/ $username = 'root'; /*** mysql password ***/ $password = 'abcd4ABCD'; function db_connect ($hostname, $username, 
$password){
    $bdd = new PDO("mysql:host=$hostname;dbname=mybookingtrainig", $username, $password);
    return $bdd; try {
    $bdd = db_connect ($hostname, $username, $password);
    $idAdvert=$_GET["idAdvert"];
    $idCandidate=$_GET["idCandidate"];
    $type=$_GET["type"];
        $stmt = $bdd->prepare("INSERT INTO Macthed(`idAdvert`, `idCandidate`, `Type`) VALUES ($idAdvert, $idCandidate, $type)");
        $nombre = $stmt->execute();
        if($nombre == 1)
        {
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
