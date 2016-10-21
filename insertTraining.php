<?php $hostname = '164.132.195.67'; /*** mysql username ***/ $username = 'root'; /*** mysql password ***/ $password = 'abcd4ABCD'; function db_connect ($hostname, $username,
$password){
    $bdd = new PDO("mysql:host=$hostname;dbname=mybookingtraining", $username, $password);
    return $bdd; try {
    $bdd = db_connect ($hostname, $username, $password);
    $description=$_GET["description"];
    $idCompany=$_GET["idCompany"];
        $stmt = $bdd->prepare("INSERT INTO Training(`description`, `idCompany`) VALUES ($description, $idCompany)");
        $nombre = $stmt->execute();
        if($nombre == 1)
        {
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
