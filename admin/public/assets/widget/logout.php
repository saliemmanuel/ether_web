<?php
include("../../../private/inc.php");
$id_utilisateur  = $_GET['id_utilisateur'];
$etherdb = getEtherdb();
API_ADMIN::seDeconnecter($_SESSION);
header('location:../../sign_in.php', true);

