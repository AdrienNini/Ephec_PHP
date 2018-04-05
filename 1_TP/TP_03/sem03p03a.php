<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 25/02/18
 * Time: 00:53
 */
$groupe = !empty($_GET['groupe']) ? $_GET['groupe'] : '';
?>
<form method="get" action="">
    <input type="text" name="groupe" placeholder="groupe recherché" value="<?= $groupe ?>">
    <input type="submit" value="envoi">
</form>
<?php

if (!isset($_GET['groupe']) || $_GET['groupe'] == "") die();

require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";


$sql = "select code, faculte, intitule from cours c 
        join course_class cc on c.code = cc.cours_id 
        join class cl on cc.class_id = cl.id 
        where cl.nom = ?
        order by code";

try {
    $dbName = 'minicampus';
    $dbh = new PDO("mysql:host={$__INFOS__['host']};dbname={$dbName}", $__INFOS__['user'], $__INFOS__['pswd']);


    $sth = $dbh->prepare($sql);
    $sth->execute([$groupe]);
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo creeTableau($res, "avec index", true);

    $dbh = null;

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}
