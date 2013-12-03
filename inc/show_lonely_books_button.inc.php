<?php
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
    echo "<a class=\"btn-extras\" href=\"books.php?courses=orphans&years=orphans&modules=orphans\">Show Orphan Books</a>";
?>