<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 1/03/18
 * Time: 09:31
 */

$to = 'adrien97nini@gmail.com';
$from = 'From: a.ninipereira@students.ephec.be';
$subject = 'Mail de test';
$message = 'Bonjour,

Voici mon mail « structuré ».

BàT.man';

if (mail($to, $subject, $message, $from)) echo "Sending success !";