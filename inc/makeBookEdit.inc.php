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
        $bookID = htmlentities(mysql_real_escape_string($_POST['bookID']));
        $title =htmlentities(mysql_real_escape_string($_POST['title']));
        $author1 = htmlentities(mysql_real_escape_string($_POST['author1']));
        $author2 = htmlentities(mysql_real_escape_string($_POST['author2']));
        $publisher = htmlentities(mysql_real_escape_string($_POST['publisher']));
        $year = htmlentities(mysql_real_escape_string($_POST['year']));
        $keywords = htmlentities(mysql_real_escape_string($_POST['keywords']));
        $addModule = htmlentities(mysql_real_escape_string($_POST['addModule']));
        $removeModule = htmlentities(mysql_real_escape_string($_POST['removeModule']));
        
        if (strlen($title)<7 || strlen($author1)<7 || strlen($author2)<7 || strlen($publisher)<7 || strlen($keywords)<7 || $year<1500 || $year>date('Y')) {
            header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
        }
        
        $title = substr(trim($title),0,30);
        $author1 = substr(trim($author1),0,20);
        $author2 = substr(trim($author2),0,20);
        $publisher = substr(trim($publisher),0,20);
        $keywords = substr(trim($keywords),0,100);
        $year = substr(trim($year),0,4);
        
        // test if a bookID has been passed for an edit
        if ($bookID != "") {
            // If not, Create the Add SQL
            $sql="UPDATE books SET title='".$title."',
                    author1='".$author1."',
                    author2='".$author2."',
                    publisher='".$publisher."',
                    year=".$year.",
                    keyword='".$keywords."'
                WHERE books.bid=\"".$bookID."\"";
        }
        // Run the SQL
        $results=$conn->query($sql);
        
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    $conn = null;
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addModule != "none") {
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
                    SET moduleBooks.bid=\"".$bookID."\", moduleBooks.mid =\"".$addModule."\"";
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
            $sql="DELETE FROM moduleBooks
                    WHERE moduleBooks.bid=\"".$bookID."\"
                    AND moduleBooks.mid =\"".$removeModule."\"";
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