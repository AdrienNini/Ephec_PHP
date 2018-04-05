<?php
// Start the session
//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session_tmp'));
session_name('he201440WebSite');
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="demoSession.css">
</head>
<body>

<?php

include_once "menu.inc.php";
// Set session variables
if (!isset($_SESSION['startTime'])) $_SESSION['startTime'] = date('l jS \of F Y h:i:s A');

$_SESSION['lastVisit']['start'] = date('l jS \of F Y h:i:s A');

$_SESSION['HE201440'] = "HE201440";

$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>
</body>
</html>