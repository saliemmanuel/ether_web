<?php
include("../../../private/inc.php");
$id_Rapport_intervension  = $_GET['id_Rapport_intervension'];
$etherdb = getEtherdb();
API_ADMIN::delete_rapport($id_Rapport_intervension, $etherdb);
header("location:../../list_rapport.php");

