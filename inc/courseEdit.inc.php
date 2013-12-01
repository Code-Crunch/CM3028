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
    <form id="edit" method="post" action="makeCourseEdit.inc.php">
        <fieldset class="edits">
            <?php
                if ($_GET['courses'] != "") {
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
			
			$courses = htmlentities(mysql_real_escape_string($_GET['courses']));
			
                        $sql="SELECT courses.cid, courses.title, courses.startYear, courses.duration
                        FROM courses
                        WHERE courses.cid = \"".$courses."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "<p>".$courses."</p>";
                        } else {
                            //generate table of results
                            foreach ($results as $row){
                                echo "Course ID: ".$row['cid']."<input name=\"courseID\" value=\"".$row['cid']."\" hidden></input> <br>";
                                echo "Title: <input name=\"title\" value=\"".$row['title']."\"></input> <br>";
                                echo "Start Year: <input name=\"startYear\" value=\"".$row['startYear']."\"></input> <br>";
                                echo "Duration: <input name=\"duration\" value=\"".$row['duration']."\"></input> <br>";
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
                            echo "Attach Module: <select name=\"addModule\">";
                            echo "<option value=\"none\">None</option>";
                            foreach ($results as $row){
                                echo "<option value=\"".$row['mid']."\">".$row['mid']."</option>";
                            }
                            echo "</select> To Year: <select name=\"addYear\"> ";
			    
			    $sql="SELECT *
				    FROM courses
				    WHERE courses.cid = \"". $courses . "\"
				    ORDER BY courses.title";
			    $results=$conn->query($sql);
			    if ($results->rowcount()==0){
			    } else {
				//generate table of results
			        foreach ($results as $row){
				    echo "<option value=\"none\">None</option>";
		    		    for ($i=$row['startYear'] ; $i<=$row['duration']+$row['startYear']-1 ; $i++) {
					echo "<option value=\"".$i."\">".$i."</option>";
				    }
				}
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
                        $sql="SELECT courseModules.mid, courseModules.cid
                            FROM courseModules
                            WHERE courseModules.cid = \"".$courses."\"";
                        $results=$conn->query($sql);
                        if ($results->rowcount()==0){
                            echo "No results <br/>";
                        } else {
                            //generate table of results
                            echo "Remove Module: <select name=\"removeModule\">";
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