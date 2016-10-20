<?php /**
 * Created by PhpStorm.
 * User: Ugo
 * Date: 24/08/2016
 * Time: 01:48
 */ /*** mysql hostname ***/ $hostname = '193.37.145.61'; /*** mysql username ***/ $username = 'srecc735619'; /*** mysql password ***/ $password = 'YCNNDrK2'; 
date_default_timezone_set('Europe/Paris'); function db_connect ($hostname, $username, $password){
    $bdd = new PDO("mysql:host=$hostname;dbname=srecc735619", $username, $password);
    return $bdd;
}
try {
    $bdd = db_connect ($hostname, $username, $password);
    $event_hours_id=$_GET["event_hours_id"];
    $user_id=$_GET["user_id"];
    $user_credit;
    $event_credit;
    $event_inscrit;
    foreach($bdd->query("SELECT user_credit FROM artpole_users WHERE ID = '".$user_id."'") as $row){
        $user_credit=$row["user_credit"];
    }
    foreach($bdd->query("SELECT meta_value FROM artpole_postmeta WHERE post_id = '".$event_hours_id."' AND meta_key='coût_du_cours_(credit)'") as $row){
        $event_credit=$row["meta_value"];
    }
    foreach($bdd->query("SELECT meta_value FROM artpole_postmeta WHERE post_id = '".$event_hours_id."' AND meta_key='nombres_dinscrit'") as $row){
        $event_inscrit=$row["meta_value"];
    }
    $requete = $bdd->prepare("DELETE FROM artpole_rel_user_event WHERE event_hours_id= '".$event_hours_id."' AND user_id = '".$user_id."'");
    // use exec() because no results are returned
    $nombre=$requete->execute();
    if($nombre == 1)
    {
        (int)$new_user_credit = (int)$user_credit + (int)$event_credit;
        $event_inscrit--;
        $bdd->exec("UPDATE artpole_users SET user_credit='".$new_user_credit."' WHERE ID = '".$user_id."'");
        //$bdd->exec("UPDATE artpole_event_hours SET nbInscrit='".$event_inscrit."' WHERE event_hours_id = '".$event_hours_id."'");
        $bdd->exec("UPDATE artpole_postmeta SET meta_value='".$event_inscrit."' WHERE post_id = '".$event_hours_id."' AND meta_key = 'nombres_dinscrit'");
        $response="Ok";
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
