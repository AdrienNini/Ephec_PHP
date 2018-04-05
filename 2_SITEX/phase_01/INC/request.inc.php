<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/02/18
 * Time: 17:16
 */

if (count(get_included_files()) == 1) die("--access denied--");


function gereRequete($rq) {

    switch ($rq) {
        case 'sem04':
            return 'Cette fois je te reconnais (' . $rq . ')';

        case 'sem03':
            return 'Requête « ' . $rq . " » : le TP03 est disponnible sur le serveur !";

        default:
            // return 'Je ne connais pas ce genre de métier (' . $rq . '), allez voir à coté';
            require_once '/RES/appelAjax.php';
            return RES_appelAjax($rq);
    }

}

// echo gereRequete('yolo');