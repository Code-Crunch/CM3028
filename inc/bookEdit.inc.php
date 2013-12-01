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
    <form id="edit" method="post" action="makeBookEdit.inc.php">
        <fieldset class="edits">
            <?php
                if ($_GET['books'] != "") {
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
                        
                        $sql="SELECT books.bid, books.title, books.author1, books.author2, books.publisher, books.year, books.keyword
                        FROM books
                        WHERE books.bid = \"".$books."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "<p>".$books."</p>";
                        } else {
                            //generate table of results
                            foreach ($results as $row){
                                echo "Book ID: ".$row['bid']."<input name=\"bookID\" value=\"".$row['bid']."\" hidden></input> <br>";
                                echo "Title: <input name=\"title\" value=\"".$row['title']."\"></input> <br>";
                                echo "First Author: <input name=\"author1\" value=\"".$row['author1']."\"></input> <br>";
                                echo "Second Author: <input name=\"author2\" value=\"".$row['author2']."\"></input> <br>";
                                echo "Publisher: <input name=\"publisher\" value=\"".$row['publisher']."\"></input> <br>";
                                echo "Year: <input name=\"year\" value=\"".$row['year']."\"></input> <br>";
                                echo "Keywords: <input name=\"keywords\" value=\"".$row['keyword']."\"></input> <br>";
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
                        $sql="SELECT modules.mid
                            FROM modules";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Attach To Module: <select name=\"addModule\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['mid']."\">".$row['mid']."</option>";
                            }
                            echo "</select> <br>";
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
                        $sql="SELECT moduleBooks.mid, moduleBooks.bid
                            FROM moduleBooks
                            WHERE moduleBooks.bid = \"".$books."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Remove From Module: <select name=\"removeModule\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['mid']."\">".$row['mid']."</option>";
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