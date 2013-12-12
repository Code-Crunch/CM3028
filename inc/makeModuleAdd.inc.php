<?php
    session_start();
    require_once "../config/database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
?>
<?php
// Open db connection for SQL to add a course
    try {

        $moduleID = strtoupper(htmlentities($_POST['moduleID']));
        $title = htmlentities($_POST['title']);
        $descr = htmlentities($_POST['descr']);
        $addCourse = $_POST['addCourse'];
        $addYear = htmlentities($_POST['addYear']);
        $addBook = $_POST['addBook'];
        
        if ($addCourse!="") {
            $sql="SELECT *
                    FROM courses
                    WHERE courses.cid = \"". $addCourse . "\"";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(array())) {
                if ($stmt->rowCount() != 0) {
                    while ($row = $stmt->fetch()) {
                        $sYear = $row['startYear'];
                        $duration = $row['duration'];
                    }
                }
            }
            if($addYear<$sYear || $addYear>($sYear+($duration-1))) {
                $addYear = $sYear+($duration-1);
            }
        }
        
        if (strlen($title)<7 || strlen($descr)<7 || strlen(substr(trim($moduleID),0,6))!=6) {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        $moduleID = substr(trim($moduleID),0,6);
        $title = substr(trim($title),0,30);
        $descr = substr(trim($descr),0,100);
        
        
        $sql="INSERT INTO modules VALUES (\"".$moduleID."\",
                \"".$title."\",
                \"".$descr."\")";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addCourse != "none" && $addYear != "") {
        try {
            // Create the SQL
            $sql="INSERT IGNORE INTO courseModules
                    SET courseModules.cid=\"".$addCourse."\", courseModules.mid =\"".$moduleID."\",courseModules.year =".$addYear;
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    // If Add module has been set, open a connection to the db and create the record
    if ($addBook != "none") {
        try {
            // Create the SQL
            $sql="INSERT IGNORE INTO moduleBooks
                    SET moduleBooks.mid=\"".$moduleID."\", moduleBooks.bid =\"".$addBook."\"";
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
    exit;
?>