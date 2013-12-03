<!-- ALL CODE BY SAM CUSSON -->
<?php
    session_start();
    require_once "database.inc.php";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
        header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
        exit;
    }
    try {
        $books = htmlentities($_GET['books']);
        $modules = htmlentities($_GET['modules']);
        $courses = htmlentities($_GET['courses']);
        
        if ($books != "") {
            
            $sql="SELECT * 
                FROM moduleBooks
                WHERE moduleBooks.bid = \"".$books."\"";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(array())) {
                if ($stmt->rowCount() == 0) {
                    $sql="DELETE FROM books WHERE books.bid= \"".$books."\" ";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }
            }
        } else if ($modules != "") {
            
            $sql="SELECT * 
                FROM moduleBooks
                WHERE moduleBooks.mid = \"".$modules."\"";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(array())) {
                if ($stmt->rowCount() == 0) {
                    $sql="SELECT * 
                        FROM courseModules
                        WHERE courseModules.mid = \"".$modules."\"";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute(array())) {
                        if ($stmt->rowCount() == 0) {
                            $sql="DELETE FROM modules WHERE modules.mid= \"".$modules."\" ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                        }
                    }
                }
            }
        } else if ($courses != "") {
            
            $sql="SELECT * 
                FROM courseModules
                WHERE courseModules.cid = \"".$courses."\"";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(array())) {
                if ($stmt->rowCount() == 0) {
                    $sql="DELETE FROM courses WHERE courses.cid= \"".$courses."\" ";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }
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