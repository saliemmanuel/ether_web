<?php
class API_ADMIN
{

    public static function inscription($bdd)
    {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $login = $_POST["login"];
        $mot_de_passe = md5("user");
        $telephone = $_POST["telephone"];
        $grade = $_POST["grade"];

        $requet = 'INSERT INTO `utilisateur` 
        (`id_utilisateur`, `nom`, `prenom`, `login`, `mot_de_passe`, `telephone`, `grade`) 
        VALUES (NULL, "' . $nom . '", "' . $prenom . '", "' . $login . '",
         "' . $mot_de_passe . '", "' . $telephone . '", "' . $grade . '")';

        $prepare = $bdd->prepare($requet);
        $ins = $prepare->execute();
        if ($ins === false) {
            $message = array('message' => 'E-mail déjà utiliser.', 'error' => '1');
        } else {
            $message =   array('message' => "Inscription effectué", 'error' => '0');
        }
        return $message;
    }


    // service connexion utilisateur
    public function connexion($bdd)
    {
        $login = $_POST["login"];
        $mot_de_passe = md5($_POST["mot_de_passe"]);

        $connexion = 'SELECT `id_utilisateur`,`nom`,`prenom`,`login`,
        `telephone`,`grade` FROM `utilisateur` WHERE `login` ="' . $login . '" AND
        `mot_de_passe` = "' . $mot_de_passe . '"';

        $getConnexion = $bdd->prepare($connexion);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $_SESSION['error-connexion'] = "lors de la connexion.";
            $message = array('message' => "E-mail ou mot de passe incorrect.", "error" => '1');
        } else {
            $message = array(
                'message' => "Connexion effectué ",
                'id_utilisateur' => $responce[0]['id_utilisateur'],
                'name' => $responce[0]['nom'],
                'prenom' => $responce[0]['prenom'],
                'login' => $responce[0]['login'],
                'telephone' => $responce[0]['telephone'],
                'grade' => $responce[0]['grade'],
                "error" => '0'
            );
            $_SESSION['user'] = $message;
            header("location:dashbord.php", true);
        }
        return $message;
    }


    public static function deleteUser($id_utilisateur, $bdd)
    {
        $requet = 'DELETE FROM `utilisateur` WHERE `id_utilisateur` = "' . $id_utilisateur . '"';
        $getConnexion = $bdd->prepare($requet);
        $getConnexion->execute();
    }

    public static function getUserList($id_utilisateur, $bdd)
    {
        $requet = 'SELECT `id_utilisateur`,`nom`,`prenom`,
        `login`,`telephone`,`grade` FROM `utilisateur` WHERE `id_utilisateur` != "' . $id_utilisateur . '"';
        $getConnexion = $bdd->prepare($requet);
        $getConnexion->execute();
        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce))
            return [];
        else
            return $responce;
    }

    public static function get_rapport_list()
    {
        $etherdb = getEtherdb();
        $requet = 'SELECT * FROM `rapport_intervension`';
        $getConnexion = $etherdb->prepare($requet);
        $getConnexion->execute();
        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce))
            return [];
        else
            return $responce;
    }
    public static function count_rapport()
    {
        $etherdb = getEtherdb();
        $requet = 'SELECT COUNT(*) as nombre FROM `rapport_intervension`
        WHERE 1 ';
        $getConnexion = $etherdb->prepare($requet);
        $getConnexion->execute();
        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce))
            return [];
        else
            return $responce;
    }

    public static function delete_rapport($id_Rapport_intervension, $bdd)
    {
        $requet = 'DELETE FROM `rapport_intervension` WHERE `rapport_intervension`.`id_Rapport_intervension` =  "' . $id_Rapport_intervension . '"';
        $getConnexion = $bdd->prepare($requet);
        $getConnexion->execute();
    }

    public static function count_localisation()
    {
        $etherdb = getEtherdb();
        $requet = 'SELECT COUNT(DISTINCT `localisation`) AS nombre FROM `rapport_intervension` WHERE 1;';
        $getConnexion = $etherdb->prepare($requet);
        $getConnexion->execute();
        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce))
            return [];
        else
            return $responce;
    }


    public static function getCountUser($bdd)
    {
        $requet = 'SELECT COUNT(*) AS nombre FROM `utilisateur` WHERE 1';
        $getConnexion = $bdd->prepare($requet);
        $getConnexion->execute();
        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce))
            return [];
        else
            return $responce;
    }

    public static function estConnecter($sessionUser)
    {

        if (empty($sessionUser)) {
            header('location:sign_in.php', true);
            exit();
        }
    }


    public static function seDeconnecter($sessionUser)
    {
        session_destroy();
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
