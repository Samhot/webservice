<?php /**
 * Created by PhpStorm.
 * User: Ugo
 * Date: 12/08/2016
 * Time: 16:57
 */ /*** mysql hostname ***/ $hostname = '193.37.145.61'; /*** mysql username ***/ $username = 'srecc735619'; /*** mysql password ***/ $password = 'YCNNDrK2'; function db_connect 
($hostname, $username, $password){
    $bdd = new PDO("mysql:host=$hostname;dbname=srecc735619", $username, $password);
    return $bdd;
}
// acces url = http://srec-construction.fr/ws/wsInscirptionEvent.php?event_hours_id=9&user_id=1 try {
    $bdd = db_connect ($hostname, $username, $password);
    $event_hours_id=$_GET["event_hours_id"];
    $user_id=$_GET["user_id"];
    $user_credit;
    $event_credit;
    $event_inscrit;
    $requete = $bdd->prepare("SELECT * FROM artpole_rel_user_event WHERE event_hours_id= '".$event_hours_id."' AND user_id = '".$user_id."'");
    $requete->execute();
    if ($requete->fetch() == false)
    {
        //requette si l'utilisateur a le nombre de crédit suffisent
        foreach($bdd->query("SELECT user_credit FROM artpole_users WHERE ID = '".$user_id."'") as $row){
            $user_credit=$row["user_credit"];
        }
        foreach($bdd->query("SELECT meta_value FROM artpole_postmeta WHERE post_id = '".$event_hours_id."' AND meta_key='coût_du_cours_(credit)'") as $row){
            $event_credit=$row["meta_value"];
        }
        foreach($bdd->query("SELECT meta_value FROM artpole_postmeta WHERE post_id = '".$event_hours_id."' AND meta_key='nombres_dinscrit'") as $row){
            $event_inscrit=$row["meta_value"];
        }
        if($user_credit>=$event_credit){
            $stmt = $bdd->prepare("INSERT INTO artpole_rel_user_event(`event_hours_id`, `user_id`) VALUES ($event_hours_id,'$user_id')");
            $nombre = $stmt->execute();
            if($nombre == 1)
            {
                $new_user_credit = $user_credit - $event_credit;
                $event_inscrit++;
                $bdd->exec("UPDATE artpole_users SET user_credit='".$new_user_credit."' WHERE ID = '".$user_id."'");
                $bdd->exec("UPDATE artpole_postmeta SET meta_value='".$event_inscrit."' WHERE post_id = '".$event_hours_id."' AND meta_key = 'nombres_dinscrit'");
                //$bdd->exec("UPDATE artpole_event_hours SET nbInscrit='".$event_inscrit."' WHERE event_hours_id = '".$event_hours_id."'");
                $response="Ok";
            }
    else
    {
        $response="Fail";
    }
}else{
    $response="credit";
}
    }
    // Si ça n'est pas false, maintenant le fetch se fait sur la deuxième ligne
    else
    {
        $response='inscrit';
    }
    //$stmt2 = $bdd->prepare(("UPDATE artpole_users SET user_credit "));
    //
    echo json_encode($response, JSON_FORCE_OBJECT);
    
} catch(PDOException $e) {
    echo $e->getMessage();
}
