<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

function getEtherdb()
{
    $host = "localhost";
    $dbname = "etherdb";
    $user = "root";
    $pass = "";
    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
    }
    return $bdd;
}

function getAdmindb()
{
    $host = "localhost";
    $dbname = "sungkuadmindb";
    $user = "root";
    $pass = "";
    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
    }
    return $bdd;
}
