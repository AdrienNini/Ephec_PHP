<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 7/05/18
 * Time: 12:30
 */

require_once 'INC/db.inc.php';
require_once '/all/kint/kint.php';

function getProfils($id) {
    $iDB = new Db();
    $user = $iDB->call('userProfil', [$id]);
}

d('id = 8', getProfils(8));