<?php
	session_start();
	require_once "config/database.inc.php";
	if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {} else {
		header("Location:".dirname($_SERVER['PHP_SELF'])."/index.php");
		exit;
	}
?>
<!-- Marina Shchukina, 1014481 
	BEM methodology is behind all the html elements naming conventions
	http://bem.info/method/
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xml:lang="en-GB">
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
	</head>
	<body>
		<div id="textbooksApp-courses">
			<fieldset class="back">
				<a href="index.php" class="btn">&lt; Back</a>
			</fieldset>
	
			<div class="innerWrapper">
				<h1 class="tableTitle">Courses</h1>
	
				<!-- Table markup-->
				<table class="databaseResults">
	
					<!-- Table header -->
					<thead>
						<tr>
							<th scope="col" class="wide" >Course title</th>
							<th scope="col">Year of entry</th>
							<th scope="col">Course duration</th>
							<th scope="col"></th>
							<th scope="col"></th>
						</tr>
					</thead>
			
					<!-- Table body -->
					<tbody>
						<!-- Start of Sam Cussons code -->
						<?php
							try {
								$sql="SELECT courses.cid, courses.title, courses.startYear, courses.duration
									FROM courses
									ORDER BY courses.title";
								
								$stmt = $conn->prepare($sql);
                                                                if ($stmt->execute(array())) {
									while ($row = $stmt->fetch()) {
										echo "<tr>";
										echo "<td><a href=\"years.php?courses=".$row['cid']. "\">".$row['title']."</a></td>";
										echo "<td>".$row['startYear']."</td>";
										echo "<td>".$row['duration']."</td>";
										echo "<td><a href=\"inc/courseEdit.inc.php?courses=".$row['cid']."\">Edit</a></td>";
										echo "<td><a href=\"inc/delete.inc.php?courses=".$row['cid']."\">Delete</a></td>";
										echo "</tr>";
									}
                                                                }
							} catch ( PDOException $e ) {
								echo "Query failed: " . $e->getMessage();
							}
							$conn = null;
						?>
						<!-- End of Sam Cussons code -->
					</tbody>
				</table>
				<?php
					if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) { 
						echo "<a class=\"btn-extras\" href=\"inc/courseAdd.inc.php\">Add</a>";
					}
				?>
			</div>
			<?php include_once('inc/footer.inc.php'); ?>
		</div>
	</body>
</html>
