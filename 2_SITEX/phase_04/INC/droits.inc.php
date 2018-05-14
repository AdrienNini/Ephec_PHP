<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 14/05/18
 * Time: 09:35
 */

if (count(get_included_files()) == 1) die("--access denied--");

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isAuthenticated() && in_array('admin', $_SESSION['user']['lesProfils']);
}

function isActiv() {
    return isAuthenticated() && in_array('acti', $_SESSION['user']['lesStatuts']);
}

function isReactiv() {
    return isAuthenticated() && in_array('réac', $_SESSION['user']['lesStatuts']);
}

function isMdpp() {
    return isAuthenticated() && in_array('mdpp', $_SESSION['user']['lesStatuts']);
}

function isEdit() {
    return isAdmin() || !(isActiv() || isReactiv());
}

function creeDroits() {
    $_SESSION['droitsDeBase'] = ['index', 'gestLog', 'pasvorto', 'formSubmit', 'formLogin'];

    if (isset($_SESSION['user']['droits'])) {
        $_SESSION['droits'] = &$_SESSION['user']['droits'];
    } else {
        $_SESSION['droits'] = &$_SESSION['droitsDeBase'];
    }

    if ( ! isAuthenticated()) return -1;

    $listeDesStatuts = [];
    $listeDesProfils = [];
    foreach ($_SESSION['user']['profile'] as $profil) {
        if ($profil['pEstStatus']) array_push($listeDesStatuts, $profil['pAbrev']);
        else array_push($listeDesProfils, $profil['pAbrev']);
    }

    $_SESSION['user']['lesStatuts'] = $listeDesStatuts;
    $_SESSION['user']['lesProfils'] = $listeDesProfils;

    $listeDesDroits = [];
    switch($listeDesProfils[0]) {
        case 'admin': $listeDesDroits = array_merge($listeDesDroits, ['userProfil', 'modifConfig', 'displaySession', 'clearLog', 'resetSession']);
        case 'sAdmin': $listeDesDroits = array_merge($listeDesDroits, ['testDB', 'config']);
        case 'modo': $listeDesDroits = array_merge($listeDesDroits, ['tableau', 'moderation']);
        case 'memb': $listeDesDroits = array_merge($listeDesDroits, ['sem02', 'sem03', 'sem04', 'TPsem05', 'formTP05']);
        case 'ano': $listeDesDroits = array_merge($listeDesDroits, $_SESSION['droitsDeBase']);
    }
    $_SESSION['user']['droits'] = $listeDesDroits;
    kint(d($_SESSION['user']));
}