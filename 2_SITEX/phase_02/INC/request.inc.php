<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/02/18
 * Time: 17:16
 */

if (count(get_included_files()) == 1) die("--access denied--");

function display($txt) {
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = "";
    $toSend['display'] .= $txt;
}


function gereRequete($rq) {

    global $toSend;

    switch ($rq) {
        case 'sem04':
            display('Cette fois je te reconnais (' . $rq . ')');
            break;

        case 'sem03':
            display('Requête « ' . $rq . ' » : le TP03 est disponnible sur le serveur !');
            break;

        default:
            require_once '/RES/appelAjax.php';
            $toSend = json_decode(RES_appelAjax($rq, 'action'));
    }

}

// echo gereRequete('yolo');