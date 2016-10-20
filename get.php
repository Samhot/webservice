<?php /**
 * Created by PhpStorm.
 * User: Ugo
 * Date: 12/10/2016
 * Time: 01:16
 */ /*** mysql hostname ***/ $hostname = '193.37.145.61'; /*** mysql username ***/ $username = 'srecc735619'; /*** mysql password ***/ $password = 'YCNNDrK2'; 
date_default_timezone_set('Europe/Paris'); function db_connect($hostname, $username, $password) {
    $bdd = new PDO("mysql:host=$hostname;dbname=srecc735619", $username, $password);
    return $bdd;
}
try {
    $bdd = db_connect($hostname, $username, $password);
    $result = array();
    $json = array();
    foreach($bdd->query("SELECT ID, post_title FROM artpole_posts t1 WHERE post_type = 'planning' AND post_status = 'publish'") as $row) {
        $postData = array();
        $postData['ID'] = $row['ID'];
        $postData['post_title'] = utf8_encode ($row['post_title']);
        foreach ($bdd->query("SELECT meta_key, meta_value FROM artpole_postmeta WHERE post_id = '" . $row['ID'] . "'") as $r) {
            $postData['' . utf8_encode ($r['meta_key'])] = utf8_encode ($r['meta_value']);
        }
        foreach ($bdd->query("SELECT term_id ,name FROM artpole_terms WHERE term_id = '" . $postData['choix_du_cours'] . "' OR term_id = '" . $postData['choix_du_professeur'] . "' 
OR term_id = '" . $postData['choix_de_la_salle'] . "' ") as $r) {
            if ($r['term_id'] == $postData['choix_du_professeur']) {
                $postData['professeur'] = utf8_encode ($r['name']);
            } elseif ($r['term_id'] == $postData['choix_du_cours']) {
                $postData['cours'] = utf8_encode ($r['name']);
            } elseif ($r['term_id'] == $postData['choix_de_la_salle']) {
                $postData['salle'] = utf8_encode ($r['name']);
            }
        }
        array_push($json, $postData);
    }
    echo json_encode($json , JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
    /*echo json_encode($postDatas, JSON_FORCE_OBJECT);*/
} catch (PDOException $e) {
    echo $e->getMessage();
}
