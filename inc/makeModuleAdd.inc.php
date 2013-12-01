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

        $moduleID = strtoupper(htmlentities(mysql_real_escape_string($_POST['moduleID'])));
        $title = htmlentities(mysql_real_escape_string($_POST['title']));
        $descr = htmlentities(mysql_real_escape_string($_POST['descr']));
        $addCourse = $_POST['addCourse'];
        $addYear = htmlentities(mysql_real_escape_string($_POST['addYear']));
        $addBook = $_POST['addBook'];
        
        if ($addCourse!="") {
            $sql="SELECT *
                    FROM courses
                    WHERE courses.cid = \"". $addCourse . "\"";
            $results=$conn->query($sql);
            if ($results->rowcount()==0){
            } else {
                foreach ($results as $row){
                    $sYear = $row['startYear'];
                    $duration = $row['duration'];
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
        $results=$conn->query($sql);
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    $conn = null;
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addCourse != "none" && $addYear != "") {
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
                    SET courseModules.cid=\"".$addCourse."\", courseModules.mid =\"".$moduleID."\",courseModules.year =".$addYear;
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    // If Add module has been set, open a connection to the db and create the record
    if ($addBook != "none") {
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
            $sql="INSERT IGNORE INTO moduleBooks
                    SET moduleBooks.mid=\"".$moduleID."\", moduleBooks.bid =\"".$addBook."\"";
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
?>