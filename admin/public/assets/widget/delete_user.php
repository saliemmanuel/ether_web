<?php
include("../../../private/inc.php");
$id_utilisateur  = $_GET['id_utilisateur'];
$etherdb = getEtherdb();
API_ADMIN::deleteUser($id_utilisateur, $etherdb);
header("location:../../list_user.php");

