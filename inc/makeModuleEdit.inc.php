<?php
    session_start();
    require_once "../config/database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
?>
<?php
// Open db connection for SQL to edit/add book
    try {
        
        $moduleID = htmlentities($_POST['moduleID']);
        $title = htmlentities($_POST['title']);
        $descr = htmlentities($_POST['descr']);
        $addCourse = $_POST['addCourse'];
        $addYear = intval(htmlentities($_POST['addYear']));
        $addBook = $_POST['addBook'];
        $removeCourse = $_POST['removeCourse'];
        $removeBook = $_POST['removeBook'];
        
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
        
        if (strlen($title)<7 || strlen($descr)<7) {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        
        $title = substr(trim($title),0,30);
        $descr = substr(trim($descr),0,100);
        
        
        // test if a bookID has been passed for an edit
        if ($moduleID != "") {
            // If not, Create the Add SQL
            $sql="UPDATE modules SET title='".$title."',
                    descr=\"".$descr."\"
                WHERE modules.mid=\"".$moduleID."\"";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addCourse != "none" && $addYear != "") {
        try {
            // Create the SQL
            $sql="INSERT INTO courseModules
                    VALUES (\"".$addCourse."\", \"".$moduleID."\",".$addYear.")
                    ON DUPLICATE KEY UPDATE year = (".$addYear.")";
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    // if the removeModule has been set, open the connection to the db and remove the relevant record
    if ($removeCourse != "none") {
        try {
            // Create the SQL
            $sql="DELETE FROM courseModules
                    WHERE courseModules.mid=\"".$moduleID."\"
                    AND courseModules.cid =\"".$removeCourse."\"";
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
            $sql="INSERT INTO moduleBooks
                    VALUES (\"".$moduleID."\",\"".$addBook."\")";
            // Run the SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    if ($removeBook != "none") {
        try {
            // Create the SQL
            $sql="DELETE FROM moduleBooks
                    WHERE moduleBooks.mid = \"".$moduleID."\"
                    AND moduleBooks.bid = \"".$removeBook."\"";
            // Run the SQL
            echo $sql."<br>";
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