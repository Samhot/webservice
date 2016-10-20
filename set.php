<?php /**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 16/10/2016
 * Time: 22:23
 */ /*** mysql hostname ***/ $hostname = '193.37.145.61'; /*** mysql username ***/ $username = 'srecc735619'; /*** mysql password ***/ $password = 'YCNNDrK2'; function db_connect 
($hostname, $username, $password){
    $bdd = new PDO("mysql:host=$hostname;dbname=srecc735619", $username, $password);
    return $bdd;
}
// acces url = http://srec-construction.fr/ws/wsInscirptionEvent.php?event_hours_id=9&user_id=1 try {
    $bdd = db_connect ($hostname, $username, $password);
    $title=$_GET["title"];
    $choixDuCours=$_GET["choixDuCours"];
    $date=$_GET["date"];
    $heureDebut=$_GET["heureDebut"];
    $heureFin=$_GET["heureFin"];
    $inscrit=$_GET['inscrit'];
    $nombreMaxInscrit=$_GET["nombreMaxInscrit"];
    $cout=$_GET['cout'];
    $reduction=$_GET['reduction'];
    $professeur=$_GET['professeur'];
    $salle=$_GET['salle'];
    $newId='';
    $postName=trim($title, ": ");
    foreach($bdd->query("SELECT fields FROM table ORDER BY id DESC LIMIT 1") as $row){
        $newId=intval($row["ID"])+1;
    }
    $url="http://srec-construction.fr/?post_type=planning&p=".$newId;
    if($title){
        $stmt = $bdd->prepare("INSERT INTO artpole_posts(`post_author`, `post_date`, `post_date_gmt`, `post_title`, `post_title`, `post_status`, `comment_status`, 
`ping_status`,`post_modified`, `post_modified_gmt`, `post_name`, `post_parent`, `guid`, `post_type`) VALUES ('1', NOW(), NOW(), $title, 'publish','closed','closed','closed', 
$postName, NOW(), NOW(), 0, $url, 'planning')");
        $nombre = $stmt->execute();
        if($nombre == 1)
        {
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
