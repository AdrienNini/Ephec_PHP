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

$_SESSION['lastVisit']['get'] = date('l jS \of F Y h:i:s A');

// Echo session variables that were set on previous page
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".";
?>

</body>
</html>