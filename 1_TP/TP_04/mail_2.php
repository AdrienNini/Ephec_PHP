<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 1/03/18
 * Time: 09:31
 */

$to = 'adrien97nini@gmail.com';
$subject = 'Mail de test';
$entete = 'Content-Type: text/html; charset=utf-8\r\n';


ini_set('sendmail_from', 'a.ninipereira@students.ephec.be');

$message = '<b>Bonjour,</b><br>Voici mon mail « structuré ».<br>BàT.man';

if (mail($to, $subject, $message, $entete)) echo "Sending success !";