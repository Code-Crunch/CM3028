<!-- ALL CODE BY SAM CUSSON -->
<?php
    session_start();
    require_once "database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
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
        $books = htmlentities(mysql_real_escape_string($_GET['books']));
        $modules = htmlentities(mysql_real_escape_string($_GET['modules']));
        $courses = htmlentities(mysql_real_escape_string($_GET['courses']));
        
        if ($books != "") {
            $sql="SELECT * 
                FROM moduleBooks
                WHERE moduleBooks.bid = \"".$books."\"";
            $results=$conn->query($sql);
            if ($results->rowcount()==0){
                $sql="DELETE FROM books WHERE books.bid= \"".$books."\" ";
                $conn->query($sql);
            }
        } else if ($modules != "") {
            $sql="SELECT * 
                FROM moduleBooks
                WHERE moduleBooks.mid = \"".$modules."\"";
            $results=$conn->query($sql);
            if ($results->rowcount()==0){
                $sql="SELECT * 
                    FROM courseModules
                    WHERE courseModules.mid = \"".$modules."\"";
                $results=$conn->query($sql);
                if ($results->rowcount()==0){
                    $sql="DELETE FROM modules WHERE modules.mid= \"".$modules."\" ";
                    $conn->query($sql);
                }
            } 
        } else if ($courses != "") {
            $sql="SELECT * 
                FROM courseModules
                WHERE courseModules.cid = \"".$courses."\"";
            $results=$conn->query($sql);
            if ($results->rowcount()==0){
                $sql="DELETE FROM courses WHERE courses.cid= \"".$courses."\" ";
                $conn->query($sql);
            }
        }
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    $conn = null;
     
    if ($books != "") {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/books.php?courses=orphans&years=orphans&modules=orphans");
        exit;
    } else if ($modules != "") {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/modules.php?courses=orphans&years=orphans");
        exit;
    } else if ($courses != "") {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/courses.php");
        exit;
    }    
    
?>