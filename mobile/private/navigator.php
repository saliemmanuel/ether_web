<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

require_once('inc.php');

class Navigator
{
    public function getApi($service)
    {
        $etherdb = getetherdb();
        $api  = new API_MOBILE();
        if (empty($service))
            echo $api->serviceInconnu();
        else
            switch ($service) {
                case 'connexion':
                    echo $api->connexion($etherdb);
                    break;
                case 'insert_statistique':
                    echo $api->insert_statistique($etherdb);
                    break;
                case 'update':
                    echo $api->updateUserData($etherdb);
                    break;
                case 'historique':
                    echo $api->historique($etherdb);
                    break;

                default:
                    echo $api->serviceInconnu();
                    break;
            }
    }
}
