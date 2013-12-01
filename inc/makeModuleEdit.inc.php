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
        
        $moduleID = htmlentities(mysql_real_escape_string($_POST['moduleID']));
        $title = htmlentities(mysql_real_escape_string($_POST['title']));
        $descr = htmlentities(mysql_real_escape_string($_POST['descr']));
        $addCourse = $_POST['addCourse'];
        $addYear = intval(htmlentities(mysql_real_escape_string($_POST['addYear'])));
        $addBook = $_POST['addBook'];
        $removeCourse = $_POST['removeCourse'];
        $removeBook = $_POST['removeBook'];
        
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
        }
        // Run the SQL
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
            $sql="INSERT INTO courseModules
                    VALUES (\"".$addCourse."\", \"".$moduleID."\",".$addYear.")
                    ON DUPLICATE KEY UPDATE year = (".$addYear.")";
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    
    // if the removeModule has been set, open the connection to the db and remove the relevant record
    if ($removeCourse != "none") {
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
                    WHERE courseModules.mid=\"".$moduleID."\"
                    AND courseModules.cid =\"".$removeCourse."\"";
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
            $sql="INSERT INTO moduleBooks
                    VALUES (\"".$moduleID."\",\"".$addBook."\")";
            // Run the SQL
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    
    if ($removeBook != "none") {
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
            $sql="DELETE FROM moduleBooks
                    WHERE moduleBooks.mid = \"".$moduleID."\"
                    AND moduleBooks.bid = \"".$removeBook."\"";
            // Run the SQL
            echo $sql."<br>";
            $results=$conn->query($sql);
            
        } catch ( PDOException $e ) {
            echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
    }
    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
?>