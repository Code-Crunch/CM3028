<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xml:lang="en-GB">
    <?php
        session_start();
        require_once "../config/database.inc.php";
        if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
	    header("Location:".dirname(dirname($_SERVER['PHP_SELF']))."/index.php");
            exit;
	}
    ?>
    <form id="edit" method="post" action="makeCourseAdd.inc.php">
        <fieldset class="edits">
            <?php
                
                    echo "Course ID: <input name=\"courseID\" placeholder=\"Course ID (e.g., C001)\"></input> <br>";
                    echo "Title: <input name=\"title\" placeholder=\"Course Title\"></input> <br>";
                    echo "Start Year: <input name=\"startYear\" placeholder=\"Start Year\"></input> <br>";
                    echo "Duration: <input name=\"duration\" placeholder=\"Duration\"></input> <br>";
                    
		    try {
                        $sql="SELECT modules.mid
                            FROM modules";
			
			$stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    echo "Add Module: <select name=\"addModule\">";
                            echo "<option value=\"none\">None</option>";
			    while ($row = $stmt->fetch()) {
				echo "<option value=\"".$row['mid']."\">".$row['mid']."</option>";
			    }
			    echo "</select> To Year: <input name=\"addYear\" placeholder=\"Year\"></input> <br>";
			}
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    $conn = null;
                    echo "<input type=\"submit\" name=\"Edit\" value=\"Add\">";
                
            ?>
        </fieldset>
    </form>
</html>