<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 20/02/18
 * Time: 08:43
 */

include "INC/mesFonctions.inc.php";

$tableau = [
    'bo124' => ['auteur' => 'B.Y.', 'titre' => 'Connectique', 'prix' => 5.20],
    'bo254' => ['auteur' => 'L.Ch.', 'titre' => 'Programmation C', 'prix' => 4.75],
    'bo334' => ['auteur' => 'L.Ch.', 'titre' => 'JavaScript', 'prix' => 6.40],
    'bo250' => ['auteur' => 'D.A.', 'titre' => 'Mathématiques', 'prix' => 6.10],
    'bo604' => ['auteur' => 'V.V.', 'titre' => 'Objets', 'prix' => 4.95],
    'bo025' => ['auteur' => 'D.M.', 'titre' => 'Electricité', 'prix' => 7.15],
    'bo099' => ['auteur' => 'D.M.', 'titre' => 'Phénomènes Périodiques', 'prix' => 6.95],
    'bo023' => ['auteur' => 'V.MN.', 'titre' => 'Programmation Java', 'prix' => 5.75],
    'bo100' => ['auteur' => 'D.Y.', 'titre' => 'Bases de Données', 'prix' => 6.35],
    'bo147' => ['auteur' => 'V.V.', 'titre' => 'Traitement de Signal', 'prix' => 4.85],
    'bo004' => ['auteur' => 'B.W.', 'titre' => 'Sécurité', 'prix' => 5.55],
    'bo074' => ['auteur' => 'B.Y.', 'titre' => 'Electronique digitale', 'prix' => 4.35],
    'bo257' => ['auteur' => 'D.Y.', 'titre' => 'Programmation Multimedia', 'prix' => 6.00]
];

echo monPrint_r($tableau);
echo '<br>';

echo creeTableau($tableau, "sans index");
echo '<br>';
echo creeTableau($tableau, "avec index", true);
