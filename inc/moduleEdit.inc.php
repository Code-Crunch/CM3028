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
    <form id="edit" method="post" action="makeModuleEdit.inc.php">
        <fieldset class="edits">
            <?php
                if ($_GET['modules'] != "") {
                    try {
                        $modules = htmlentities($_GET['modules']);
                        
                        $sql="SELECT modules.mid, modules.title, modules.descr
                        FROM modules
                        WHERE modules.mid = \"".$modules."\"";
			$stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    if ($stmt->rowCount() != 0) { 
				while ($row = $stmt->fetch()) {
				    echo "Module ID: ".$row['mid']."<input name=\"moduleID\" value=\"".$row['mid']."\" hidden></input> <br>";
				    echo "Title: <input name=\"title\" value=\"".$row['title']."\"></input> <br>";
				    echo "Description: <input name=\"descr\" value=\"".$row['descr']."\"></input> <br>";
				}
			    }
                        }
                    } catch ( PDOException $e ) {
                    echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT courses.cid
                            FROM courses";
                        $stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    if ($stmt->rowCount() != 0) { 
				echo "Attach To Course: <select name=\"addCourse\">";
				echo "<option value=\"none\">None</option>";
				while ($row = $stmt->fetch()) {
				    echo "<option value=\"".$row['cid']."\">".$row['cid']."</option>";
				}
				echo "</select> To Year: <input name=\"addYear\" placeholder=\"Year\"></input> <br>";
			    }
                        }
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT courseModules.cid, courseModules.cid
                            FROM courseModules
                            WHERE courseModules.mid =\"".$modules."\"";
                        $stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    if ($stmt->rowCount() != 0) {
				echo "Detach From Course: <select name=\"removeCourse\">";
				echo "<option value=\"none\">None</option>";
				while ($row = $stmt->fetch()) {
				    echo "<option value=\"".$row['cid']."\">".$row['cid']."</option>";
				}
				echo "</select><br>";
			    }
			}
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT books.bid, books.title
                            FROM books";
                        $stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    if ($stmt->rowCount() != 0) {
				//generate table of results
				echo "Attach Book to Module: <select name=\"addBook\">";
				echo "<option value=\"none\">None</option>";
				while ($row = $stmt->fetch()) {
				    echo "<option value=\"".$row['bid']."\">".$row['bid']."</option>";
				}
				echo "</select> <br>";
			    }
                        }
                    } catch ( PDOException $e ) {
                        echo "Query failed: " . $e->getMessage();
                    }
                    
                    try {
                        $sql="SELECT books.bid, books.title
                            FROM books
                            LEFT JOIN modulebooks ON books.bid = moduleBooks.bid
                            WHERE moduleBooks.mid = \"".$modules."\"";
                        $stmt = $conn->prepare($sql);
			if ($stmt->execute(array())) {
			    if ($stmt->rowCount() != 0) {
				//generate table of results
				echo "Detach Book From Module: <select name=\"removeBook\">";
				echo "<option value=\"none\">None</option>";
				while ($row = $stmt->fetch()) {
				    echo "<option value=\"".$row['bid']."\">".$row['bid']."</option>";
				}
				echo "</select> <br>";
			    }
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