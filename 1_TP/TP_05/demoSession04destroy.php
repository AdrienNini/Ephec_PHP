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
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

</body>
</html>