<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

require_once('inc.php');

// classe gestion des services de l'api
class Navigator
{
    public function getApi($service)
    {
        $etherdb = getEtherdb();
        $api  = new API_ADMIN();
        if (empty($service))
            echo $api->serviceInconnu();
        else
            switch ($service) {
                case 'inscription':
                    echo $api->inscription($etherdb);
                    break;
                case 'connexion':
                    return $api->connexion($etherdb);
                    break;

                default:
                    echo $api->serviceInconnu();
                    break;
            }
    }
}
