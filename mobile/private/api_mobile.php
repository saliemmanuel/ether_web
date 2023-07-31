<?php
class API_MOBILE
{

    // service connexion utilisateur
    public function connexion($bdd)
    {
        $login = $_POST["login"];
        $mot_de_passe = md5($_POST["mot_de_passe"]);

        $connexion = 'SELECT * FROM `utilisateur` WHERE `login` = "' . $login . '" AND
        `mot_de_passe` = "' . $mot_de_passe . '"';

        $getConnexion = $bdd->prepare($connexion);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Identifiant incorrect contacter un admin.", "error" => '1');
        } else {
            $message = array(
                'message' => "Connexion effectué ",
                'id_utilisateur' => $responce[0]['id_utilisateur'],
                'nom' => $responce[0]['nom'],
                'prenom' => $responce[0]['prenom'],
                'login' => $responce[0]['login'],
                'telephone' => $responce[0]['telephone'],
                'grade' => $responce[0]['grade'],
                "error" => '0'
            );
        }
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    // insertion des statistiques et des rapports
    public function insert_statistique($bdd)
    {
        $rapport_appel = $_POST["rapport_appel"];
        $id_utilisateur = $_POST["id_utilisateur"];
        $data = json_decode($_POST["data"]);
        $date = date("m-d-Y");


        for ($i = 0; $i < count($data); $i++) {
            $requete = 'INSERT INTO `rapport_intervension` (`id_Rapport_intervension`, `RSRP`, `qualite`,
         `RSRQ`, `qualites`, `localisation`, `dates`,
          `id_utilisateur`) VALUES (NULL, "' . $data[$i]->RSRP . '", 
          "' . $data[$i]->qualite . '", "' . $data[$i]->RSRQ . '", 
          "' . $data[$i]->qualites . '", "' . $data[$i]->localisation . '", "' . $date . '", "' .  $id_utilisateur . '")';

            $getInst = $bdd->prepare($requete);
            $getInst->execute();
        }

        $query = 'INSERT INTO `statistique` (`id_statistique`, `rapport_appel`, 
          `id_utilisateur`, `date`) VALUES (NULL, "' . $rapport_appel . '", "' . $id_utilisateur . '", 
          "' . $date . '");';

        $getCSet = $bdd->prepare($query);
        $getCSet->execute();
        $message = array('message' => "Sauvegarde effectuée",  "error" => '0');
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }


    public function updateUserData($bdd)
    {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $login = $_POST["login"];
        $telephone = $_POST["telephone"];
        $id_utilisateur = $_POST["id_utilisateur"];

        $query = 'UPDATE `utilisateur` SET 
        `nom`= "' . $nom . '",
        `prenom`= "' . $prenom . '",
        `login`= "' . $login . '",
        `telephone`= "' . $telephone . '" WHERE `id_utilisateur` = "' . $id_utilisateur . '"';

        $getConnexion = $bdd->prepare($query);
        $getConnexion->execute();

        $connexion = 'SELECT * FROM `utilisateur` WHERE `id_utilisateur` ="' . $id_utilisateur . '"';

        $getConnexion = $bdd->prepare($connexion);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Identifiant incorrect contacter un admin.", "error" => '1');
        } else {
            $message = array(
                'message' => "Connexion effectué ",
                'id_utilisateur' => $responce[0]['id_utilisateur'],
                'nom' => $responce[0]['nom'],
                'prenom' => $responce[0]['prenom'],
                'login' => $responce[0]['login'],
                'telephone' => $responce[0]['telephone'],
                'grade' => $responce[0]['grade'],
                "error" => '0'
            );
        }
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function historique($bdd)
    {
        $id_utilisateur = $_POST["id_utilisateur"];
        $connexion = 'SELECT * FROM `rapport_intervension` WHERE  `id_utilisateur` ="' . $id_utilisateur . '"';

        $getConnexion = $bdd->prepare($connexion);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Aucun rapport", "error" => '1');
        } else {
            $message = array(
                'message' => " effectué ",
                'data' => $responce,
                "error" => '0'
            );
        }
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }
    // GESTION DES ERREURS DE L'API 
    public function serviceInconnu()
    {
        http_response_code(400);
        return json_encode(["message" => "service Inconnu", "error" => "1"], JSON_UNESCAPED_UNICODE);
    }

    public function errorToken()
    {
        http_response_code(400);
        return json_encode(["message" => "Token invalide", "error" => "1"], JSON_UNESCAPED_UNICODE);
    }
}
