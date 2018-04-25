<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/02/18
 * Time: 17:16
 */

if (count(get_included_files()) == 1) die("--access denied--");

require_once 'mesFonctions.inc.php';

function display($txt) {
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = "";
    $toSend['display'] .= $txt;
}

function error($txt) {
    global $toSend;
    if (!isset($toSend['error'])) $toSend['error'] = "";
    $toSend['error'] .= $txt;
}

function debug($txt) {
    global $toSend;
    if (!isset($toSend['debug'])) $toSend['debug'] = "";
    $toSend['debug'] .= $txt;
}

function kint($txt) {
    global $toSend;
    if (!isset($toSend['kint'])) $toSend['kint'] = "";
    $toSend['kint'] .= $txt;
}

function toSend($txt, $action = 'display') {
    global $toSend;
    if (!isset($toSend[$action])) $toSend[$action] = "";
    $toSend[$action] .= $txt;
}

function callResAjax($rq) {
    require_once '/RES/appelAjax.php';
    global $toSend;
    $toSend = array_merge($toSend, (Array) json_decode(RES_appelAjax($rq, 'action')));
}

function chargeTemplate($name = 'yololo') {
    $name = 'INC/template.' . strtolower($name) . '.inc.php';
    return file_exists($name) ? implode("\n", file($name)) : false;
}

function tpSem05() {
    require_once '/RES/appelAjax.php';
    toSend(chargeTemplate('tpsem05'), 'formTP05');
    toSend(RES_appelAjax('allGroups'),'data');
}

function gereSubmit() {
    if (!isset($_POST['senderId'])) $_REQUEST['senderId'] = '';
    switch ($_POST['senderId']) {
        case 'formTP05':
            require_once '/RES/appelAjax.php';
            toSend('#tp05result div', 'destination');
            toSend('#tp05result p', 'cacher');
            //toSend(monPrint_r(RES_appelAjax('coursGroup')), 'debug');
            sendMakeTable(RES_appelAjax('coursGroup'));
            break;
        default:
            error('<dl><dt>Error in <b>' . __FUNCTION__ . '()</b></dt><dt>'. monPrint_r(["_REQUEST" => $_REQUEST, "_FILES" => $_FILES]) .'</dt></dl>');
            break;
    }

}

function sendMakeTable($tab) {
    global $toSend;
    if (!isset($toSend['makeTable'])) $toSend['makeTable'] = "";
    $toSend['makeTable'] = $tab;
}

function gereRequete($rq) {
    kint(d($rq));
    switch ($rq) {
        case 'sem04': toSend('Cette fois je te reconnais (' . $rq . ')', 'display'); break;
        case 'sem03': toSend('Requête « ' . $rq . ' » : le TP03 est disponnible sur le serveur !', 'display'); break;
        case 'TPsem05': tpSem05(); break;
        case 'formSubmit': gereSubmit(); break;
        case 'displaySession':
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            $_SESSION['log'][time()] = $rq;
            break;
        case 'clearLog':
            $_SESSION['log'] = [];
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'resetSession':
            session_unset();
            $_SESSION['start'] = date('Ymdhms');
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        default:
            callResAjax($rq);
            kint('requête inconnue (' . $rq . ') transférée à callResAjax()');
            break;

    }
}
// echo gereRequete('yolo');



