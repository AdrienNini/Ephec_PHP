<?php
/**
 * Created by PhpStorm.
 * User: he201440
 * Date: 19/02/2018
 * Time: 11:35
 */

include "INC/mesFonctions.inc.php";

?><!DOCTYPE html>
<html>
    <head>
        <title>TP Semaine 02 - Partie 1d</title>
        <link rel="stylesheet" href="CSS/index.css">
        <meta charset="utf-8">
    </head>
    <body>

        <h1>TP Semaine 02 - Partie 1d</h1>

        <table>
            <thead>
                <tr>
                    <th>Paramètre</th>
                    <th>Retour</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>new</td>
                    <td><?= '<pre>' . print_r(scriptInfos("new"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>Empty</td>
                    <td><?= '<pre>' . print_r(scriptInfos("empty"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>proTocol</td>
                    <td><?= '<pre>' . print_r(scriptInfos("proTocol"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>poRt</td>
                    <td><?= '<pre>' . print_r(scriptInfos("poRt"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>isPortDef</td>
                    <td><?= '<pre>' . print_r(scriptInfos("isPortDef"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>dNs</td>
                    <td><?= '<pre>' . print_r(scriptInfos("dNs"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>path</td>
                    <td><?= '<pre>' . print_r(scriptInfos("path"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>naME</td>
                    <td><?= '<pre>' . print_r(scriptInfos("naME"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>short</td>
                    <td><?= '<pre>' . print_r(scriptInfos("short"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>EXT</td>
                    <td><?= '<pre>' . print_r(scriptInfos("EXT"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>all</td>
                    <td><?= '<pre>' . print_r(scriptInfos("all"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>full</td>
                    <td><?= '<pre>' . print_r(scriptInfos("full"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>root</td>
                    <td><?= '<pre>' . print_r(scriptInfos("root"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>Machin truc</td>
                    <td><?= '<pre>' . print_r(scriptInfos("Machin truc"), true) . '</pre>' ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
