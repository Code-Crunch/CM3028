<?php
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
    	header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
    echo "<a class=\"btn-extras\" href=\"modules.php?courses=orphans&years=orphans\">Show Orphan Modules</a>";
?>