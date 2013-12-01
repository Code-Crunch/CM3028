<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xml:lang="en-GB">
    <?php
        session_start();
        require_once "database.inc.php";
        if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
	    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
	}
    ?>
    <form id="edit" method="post" action="makeModuleEdit.inc.php">
        <fieldset class="edits">
            <?php
                if ($_GET['modules'] != "") {
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
                        $modules = htmlentities(mysql_real_escape_string($_GET['modules']));
                        
                        $sql="SELECT modules.mid, modules.title, modules.descr
                        FROM modules
                        WHERE modules.mid = \"".$modules."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "<p>".$modules."</p>";
                        } else {
                            //generate table of results
                            foreach ($results as $row){
                                echo "Module ID: ".$row['mid']."<input name=\"moduleID\" value=\"".$row['mid']."\" hidden></input> <br>";
                                echo "Title: <input name=\"title\" value=\"".$row['title']."\"></input> <br>";
                                echo "Description: <input name=\"descr\" value=\"".$row['descr']."\"></input> <br>";
                            }
                        }
                    } catch ( PDOException $e ) {
                    echo "Query failed: " . $e->getMessage();
                    }
                    $conn = null;
                    
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
                        $sql="SELECT courses.cid
                            FROM courses";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Attach To Course: <select name=\"addCourse\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['cid']."\">".$row['cid']."</option>";
                            }
			    echo "</select> To Year: <input name=\"addYear\" placeholder=\"Year\"></input> <br>";
                        }
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT courseModules.cid, courseModules.cid
                            FROM courseModules
                            WHERE courseModules.mid =\"".$modules."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Detach From Course: <select name=\"removeCourse\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['cid']."\">".$row['cid']."</option>";
                            }
                             echo "<option value=\"all\">All</option>";
                            echo "</select><br>";
			}
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    $conn = null;
                    
    
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
                        $sql="SELECT books.bid, books.title
                            FROM books";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Attach Book to Module: <select name=\"addBook\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['bid']."\">".$row['bid']."</option>";
                            }
                            echo "</select> <br>";
                        }
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT books.bid, books.title
                            FROM books
                            LEFT JOIN modulebooks ON books.bid = moduleBooks.bid
                            WHERE moduleBooks.mid = \"".$modules."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Detach Book From Module: <select name=\"removeBook\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['bid']."\">".$row['bid']."</option>";
                            }
                            echo "<option value=\"all\">All</option>";
                            echo "</select> <br>";
                        }
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    
                    
                    $conn = null;
                    echo "<input type=\"submit\" name=\"Edit\" value=\"Edit\">";
                }
            ?>
        </fieldset>
    </form>
</html>