<?php $hostname = '193.37.145.61'; /*** mysql username ***/ $username = 'srecc735619'; /*** mysql password ***/ $password = 'YCNNDrK2'; function db_connect ($hostname, $username, 
$password){
    $bdd = new PDO("mysql:host=$hostname;dbname=srecc735619", $username, $password);
    return $bdd;
}
try {
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
