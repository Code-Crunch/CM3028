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
        $addModule = $_POST['addModule'];
        $removeModule = $_POST['removeModule'];
        
        
        
        $sql="SELECT *
                FROM courseModules
                WHERE courseModules.cid = \"". $courseID . "\"";
        $results=$conn->query($sql);
        if ($results->rowcount()==0){
        } else {
            foreach ($results as $row){
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
        }
        // Run the SQL
        $results=$conn->query($sql);
        
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    $conn = null;
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addModule != "none" && $addYear != "none") {
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
            $sql="INSERT INTO courseModules
                    VALUES (\"".$courseID."\", \"".$addModule."\",".$addYear.")
                    ON DUPLICATE KEY UPDATE year = (".$addYear.")";
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    
    // if the removeModule has been set, open the connection to the db and remove the relevant record
    if ($removeModule != "none") {
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
            $sql="DELETE FROM courseModules
                    WHERE courseModules.cid=\"".$courseID."\"
                    AND courseModules.mid =\"".$removeModule."\"";
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