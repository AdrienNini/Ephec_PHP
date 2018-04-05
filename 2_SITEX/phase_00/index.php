<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 9/02/18
 * Time: 17:34
 */


// Prerequired includes

require "INC/dbConnect.inc.php";

// Variables initalisation

$title = 'Accueil';
$blogName = 'Nom de mon site';
$logoPath = 'IMG/04.png';
$logoAlt = 'logo';
$mainContent = 'Bienvenue';


$mail = ___MATRICULE___ . '@students.ephec.be';
$auteur = "<a href=mailto:$mail title=$mail>". $__INFOS__['nom'] ." ". $__INFOS__['prenom'] ."@2018</a>";


include "INC/layout.html.inc.php";