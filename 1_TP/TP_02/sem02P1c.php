<?php
/**
 * Created by PhpStorm.
 * User: he201440
 * Date: 19/02/2018
 * Time: 10:54
 */

echo 'Protocole : ' . $_SERVER['SERVER_PORT_SECURE'] . ' - ' . $_SERVER['SERVER_PROTOCOL'] . '<br>';

echo 'Port : ' . $_SERVER['SERVER_PORT'] . '<br>';

echo 'DNS : ' . $_SERVER['SERVER_NAME']  .'<br>';

echo '<pre>' . print_r($url = pathinfo($_SERVER['URL']), true) . '</pre><br>';

echo 'Chemin : ' . $url['dirname'] . '<br>';

echo 'Script : ' . $url['basename'] . '<br>';