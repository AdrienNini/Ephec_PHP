<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 1/03/18
 * Time: 09:31
 */

if (isset($_POST['dest']) && isset($_POST['sub']) && isset($_POST['msg'])) {
    if (!empty($_POST['dest']) && !empty($_POST['sub']) && !empty($_POST['msg'])) {
        $to = $_POST['dest'];
        $subject = $_POST['sub'];
        $entete = 'Content-Type: text/html; charset=utf-8\r\n';

        ini_set('sendmail_from', 'a.ninipereira@students.ephec.be');

        $message = $_POST['msg'];

        if (mail($to, $subject, $message, $entete)) echo '<div style="color: green;">Sending success !</div>';
    }
}

