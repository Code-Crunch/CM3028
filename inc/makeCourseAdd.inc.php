<?php
    session_start();
    require_once "database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
?>
<?php
// Open db connection for SQL to add a course
    try {
        $dsn = "mysql:host=localhost;dbname=".$mysqldatabase;
        // try connecting to the database
        $conn = new PDO($dsn, $mysqlusername, $mysqlpassword);
        // turn on PDO exception handling 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // enter catch block in event of error in preceding try block
        echo "Connection failed: ".$e->getMessage();
    }
    try {
        $courseID = htmlentities(mysql_real_escape_string($_POST['courseID']));
        $title = htmlentities(mysql_real_escape_string($_POST['title']));
        $startYear = htmlentities(mysql_real_escape_string($_POST['startYear']));
        $duration = htmlentities(mysql_real_escape_string($_POST['duration']));
        $addYear = htmlentities(mysql_real_escape_string($_POST['addYear']));
        $addModule = htmlentities(mysql_real_escape_string($_POST['addModule']));
        
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
        $results=$conn->query($sql);
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addYear != "") {
        try {
           $dsn = "mysql:host=localhost;dbname=".$mysqldatabase;
            // try connecting to the database
            $conn = new PDO($dsn, $mysqlusername, $mysqlpassword);
            // turn on PDO exception handling 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // enter catch block in event of error in preceding try block
            echo "Connection failed: ".$e->getMessage();
        }
        try {
            // Create the SQL
            $sql="INSERT IGNORE INTO courseModules
                    SET courseModules.cid=\"".$courseID."\", courseModules.mid =\"".$addModule."\",courseModules.year =".$addYear;
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/courses.php");
	exit;
?>