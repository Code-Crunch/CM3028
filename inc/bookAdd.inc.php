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
    <form id="edit" method="post" action="makeBookAdd.inc.php">
        <fieldset class="edits">
            <?php
                if ($_GET['books'] == "") {
                    echo "Book ID: <input name=\"bookID\" placeholder=\"Book ID\"></input> <br>";
                    echo "Title: <input name=\"title\" placeholder=\"Book Title\"></input> <br>";
                    echo "First Author: <input name=\"author1\" placeholder=\"First Author\"></input> <br>";
                    echo "Second Author: <input name=\"author2\" placeholder=\"Second Author\"></input> <br>";
                    echo "Publisher: <input name=\"publisher\" placeholder=\"Publisher\"></input> <br>";
                    echo "Year: <input name=\"year\" placeholder=\"Year Published\"></input> <br>";
                    echo "Keywords: <input name=\"keywords\" placeholder=\"Keywords\"></input> <br>";
                    
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
                    echo "<input type=\"submit\" name=\"Edit\" value=\"Add\">";
                }
            ?>
        </fieldset>
    </form>
</html>