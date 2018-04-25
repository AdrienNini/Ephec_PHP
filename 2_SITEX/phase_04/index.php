<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 9/02/18
 * Time: 17:34
 */

// SESSION

session_start();
if (!isset($_SESSION['start'])) {
    $_SESSION['start'] = date('Ymdhms');
    $_SESSION['log'] = [];
}

// Prerequired includes

require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";
require_once "/ALL/kint/kint.php";
Kint::$return=true;

if (isset($_GET['rq'])) {
    $_SESSION['log'][time()] = $_GET['rq'];
    $toSend = [];
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
} else {
    $_SESSION['log'][time()] = 'resetF5';
}



// Variables initalisation

$title = 'Accueil';
$blogName = 'SITEX : phase 03 TPsem05';
$logoPath = 'IMG/04.png';
$logoAlt = 'logo';
$mainContent = 'Bienvenue';

$mail = ___MATRICULE___ . '@students.ephec.be';
$auteur = "<a href=mailto:$mail title=$mail>". $__INFOS__['nom'] ." ". $__INFOS__['prenom'] ."@2018</a>";


require_once "INC/layout.html.inc.php";