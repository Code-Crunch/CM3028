<?php
    session_start();
    require_once "database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
?>
<?php
// Open db connection for SQL to edit/add book
    try {
        $courseID = htmlentities($_POST['courseID']);
        $title = htmlentities($_POST['title']);
        $startYear = htmlentities($_POST['startYear']);
        $duration = htmlentities($_POST['duration']);
        $addYear = htmlentities($_POST['addYear']);
        $addModule = $_POST['addModule'];
        $removeModule = $_POST['removeModule'];
        
        $sql="SELECT *
                FROM courseModules
                WHERE courseModules.cid = \"". $courseID . "\"";
        $stmt = $conn->prepare($sql);
        $stmt->execute();   
        if ($results->rowcount()!=0) {
            while ($row = $stmt->fetch()) {
                if ($row['year']<$startYear || $row['year']>($startYear+$duration-1)) {
                    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
                    exit;
                }
            }
        }
        
        if (strlen($title)<7 || $startYear<1 || $duration<1) {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        
        if($addYear!="" && $addYear>=$startYear && $addYear<=($startYear+$duration)) {
            $addYear = substr(trim($addYear),0,strlen($startYear+$duration));
        } else {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        
        $title = substr(trim($title),0,30);
        
        // test if a bookID has been passed for an edit
        if ($courseID != "") {
            // If not, Create the Add SQL
            $sql="UPDATE courses SET title='".$title."',
                    startYear=".$startYear.",
                    duration=".$duration."
                WHERE courses.cid=\"".$courseID."\"";
            $stmt = $conn->prepare($sql);
            $stmt->execute();   
        }
        
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addModule != "none" && $addYear != "none") {
        try {
            // Create the SQL
            $sql="INSERT INTO courseModules
                    VALUES (\"".$courseID."\", \"".$addModule."\",".$addYear.")
                    ON DUPLICATE KEY UPDATE year = (".$addYear.")";
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();   
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    // if the removeModule has been set, open the connection to the db and remove the relevant record
    if ($removeModule != "none") {
        try {
            // Create the SQL
            $sql="DELETE FROM courseModules
                    WHERE courseModules.cid=\"".$courseID."\"
                    AND courseModules.mid =\"".$removeModule."\"";
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