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
        // test if a bookID has been passed for an edit
        if ($_POST['bookID'] != "") {
            //If so, Create the Edit SQL
            $bookID = htmlentities($_POST['bookID']);
            $title = htmlentities($_POST['title']);
            $author1 = htmlentities($_POST['author1']);
            $author2 = htmlentities($_POST['author2']);
            $publisher = htmlentities($_POST['publisher']);
            $year = htmlentities($_POST['year']);
            $keywords = htmlentities($_POST['keywords']);
            $addModule = htmlentities($_POST['addModule']);
            
            
            
            if (strlen($title)<7 || strlen($author1)<7 || strlen($publisher)<7 || strlen($keywords)<14 || $year<1500 || $year>=date('Y') || strlen(substr(trim($bookID),0,4))!=4) {
                header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
                exit;
            }
            
            $bookID = substr(trim($bookID),0,4);
            $title = substr(trim($title),0,30);
            $author1 = substr(trim($author1),0,20);
            $author2 = substr(trim($author2),0,20);
            $publisher = substr(trim($publisher),0,20);
            $keywords = substr(trim($keywords),0,100);
            $year = substr(trim($year),0,4);
            
            
            $sql="INSERT INTO books VALUES (\"".$bookID."\",
                    \"".$title."\",
                    \"".$author1."\",
                    \"".$author2."\",
                    \"".$publisher."\",
                    ".$year.",
                    \"".$keywords."\")";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    } catch ( PDOException $e ) {
        echo "Query failed: " . $e->getMessage();
    }
    
    // If Add module has been set, open a connection to the db and create the record
    if ($addModule != "none") {
        
        try {
            
            $sql="INSERT IGNORE INTO moduleBooks SET moduleBooks.bid=\"".
                    $bookID."\", moduleBooks.mid =\"".$addModule."\"";
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