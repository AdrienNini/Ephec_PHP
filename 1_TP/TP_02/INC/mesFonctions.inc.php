<?php
/**
 * Created by PhpStorm.
 * User: he201440
 * Date: 19/02/2018
 * Time: 11:32
 */

/**
 * @param string $param
 * @return array|null|string
 */
function scriptInfos($param = "new") {

    static $answer;

    $param = strtolower($param);

    switch ($param) {
        case "new":
            $url = pathinfo($_SERVER['URL']);
            $answer = array(
                'protocol' => $_SERVER['SERVER_PORT_SECURE'] . ' - ' . isset($_SERVER['HTTPS']) ? "https" : "http",
                'port' => $_SERVER['SERVER_PORT'],
                'dns' => $_SERVER['SERVER_NAME'],
                'path' => $url['dirname'],
                'name' => $url['basename'],
                'short' => $url['filename'],
                'ext' => $url['extension'],
                'isportdef' => $_SERVER['SERVER_PORT_SECURE']
            );
            break;

        case "empty":
            $answer = null;
            break;

        case "all":
            if ($answer == null || !is_array($answer)) $answer = scriptInfos();
            break;

        case "full":
            $answer = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            break;

        case "root":
            $answer = $_SERVER['URL'];
            break;

        case in_array($param, array_keys(scriptInfos())):
            $answer = $answer[$param];
            break;

        default:
            $answer = 'Error in ' . __FUNCTION__ . ' on line ' . __LINE__ . ' : paramètre inconnu (' . $param . ')';
            break;

    }

    return $answer;

}

function creeTableau($tab, $title = '', $index = false) {
    $out = '<table><caption>'. $title .'</caption>';
    $out .= '<tr>';

    $keys = array_keys($tab[array_keys($tab)[0]]);

    if ($index) $out .= '<th>index</th>';
    foreach ($keys as $k) {
        $out .= '<th>' . $k . '</th>';
    }

    $out .= '</tr>';

    foreach ($tab as $x => $x_value) {
        $out .= '<tr>';
        if ($index) $out .= '<td>' . $x . '</td>';
        foreach ($x_value as $y => $y_value) {
            $out .= '<td>' . $y_value . '</td>';
        }
        $out .= '</tr>';
    }

    $out .= '</table>';
    return $out;
}

function monPrint_r($tab) {
    return '<pre>' . print_r($tab, true) . '</pre>';
}