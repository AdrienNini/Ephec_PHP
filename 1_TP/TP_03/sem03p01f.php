<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 25/02/18
 * Time: 00:53
 */

require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";

$sql = 'select code, faculte, intitule from cours c 
        join course_class cc on c.code = cc.cours_id 
        join class cl on cc.class_id = cl.id 
        where cl.nom = \'1TL2\' 
        order by code';

try {
    $dbName = 'minicampus';
    $dbh = new PDO("mysql:host={$__INFOS__['host']};dbname={$dbName}", $__INFOS__['user'], $__INFOS__['pswd']);

    echo json_encode($dbh->query($sql, PDO::FETCH_ASSOC)->fetchAll());

    $dbh = null;

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}
