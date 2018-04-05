<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 1/03/18
 * Time: 09:31
 */

if (!isset($_POST)) die('<div style="color: red;">Erreur: paramètre manquant !</div>');
if (empty($_POST['expe']) || empty($_POST['sub']) || empty($_POST['msg'])) die('<div style="color: red;">Erreur: paramètre vide !</div>');


// First mail

ini_set('sendmail_from', $_POST['expe']);
$me = 'adrien97nini@gmail.com';

$entete = 'Content-Type: text/html; charset=utf-8\r\n';

if (!mail($me, $_POST['sub'], $_POST['msg'], $entete)) die('<div style="color: red;">Erreur: L\'envoie de l\'email à échoué !</div>');

// Second mail

ini_set('sendmail_from', $me);

$subject = 'Confirmation de votre prise de contact';
$msg = '<table>';
$msg .= '<tr>';
    $msg .= '<td><b>Expéditeur :</b></td>';
    $msg .= '<td>' . $me . '</td>';
$msg .= '</tr>';
$msg .= '<tr>';
$msg .= '<td><b>Sujet :</b></td>';
$msg .= '<td>' . $_POST['sub'] . '</td>';
$msg .= '</tr>';
$msg .= '<tr>';
$msg .= '<td><b>Contenu :</b></td>';
$msg .= '<td>' . $_POST['msg'] . '</td>';
$msg .= '</tr>';

if (!mail($_POST['expe'], $subject, $msg, $entete)) die('<div style="color: red;">Erreur: L\'envoie de l\'email à échoué !</div>');

header('Location: form_contact.html');

