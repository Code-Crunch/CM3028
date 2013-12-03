<?php
    session_start();
    require_once "database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
?>
<?php
    try {
        $courseID = htmlentities($_POST['courseID']);
        $title = htmlentities($_POST['title']);
        $startYear = htmlentities($_POST['startYear']);
        $duration = htmlentities($_POST['duration']);
        $addYear = htmlentities($_POST['addYear']);
        $addModule = htmlentities($_POST['addModule']);
        
        if (strlen($title)<7 || $startYear<1 || $duration<1 || strlen(substr(trim($courseID),0,4))!=4) {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        $courseID = substr(trim($courseID),0,4);
        $title = substr(trim($title),0,30);
        
        if($addYear!="") {
            if ($addYear>=$startYear && $addYear<=($startYear+$duration)) {
                $addYear = substr(trim($addYear),0,strlen($startYear+$duration));
            } else {
                header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
                exit;
            } 
        }
        
        
        $sql="INSERT INTO courses VALUES (\"".$courseID."\",
                \"".$title."\",
                ".$startYear.",
                ".$duration.")";
	    $stmt = $conn->prepare($sql);
            $stmt->execute();   
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addYear != "") {
        try {
            // Create the SQL
            $sql="INSERT IGNORE INTO courseModules
                    SET courseModules.cid=\"".$courseID."\", courseModules.mid =\"".$addModule."\",courseModules.year =".$addYear;
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/courses.php");
	exit;
?>