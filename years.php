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
		<div id="textbooksApp-years">
			<fieldset class="back">
				<a href="courses.php" class="btn">&lt; Back</a>
			</fieldset>
	
			<div class="innerWrapper">
				<h1 class="tableTitle">Years</h1>
	
				<!-- Table markup-->
				<table class="databaseResults">
	
					<!-- Table header -->
					<thead>
						<tr>
							<th scope="col" class="wide" >Year</th>
						</tr>
					</thead>
		
					<!-- Table body -->
					<tbody>
						<!-- Start of Sam Cussons code -->
						<?php
							try {
								$courses = htmlentities($_GET['courses']);
								$sql="SELECT *
									FROM courses
									WHERE courses.cid = \"". $courses . "\"
									ORDER BY courses.title";
								$stmt = $conn->prepare($sql);
                                                                if ($stmt->execute(array())) {
									echo "<tr><td><a href=\"modules.php?courses=".$courses."&years=select-year\">All</a></td></tr>";
									while ($row = $stmt->fetch()) {
										for ($i=$row['startYear'] ; $i<=$row['duration']+$row['startYear']-1 ; $i++) {
											echo "<tr><td><a href=\"modules.php?courses=".$courses."&years=".$i."\">".$i."</a></td></tr>";
										}
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
			</div>
			<?php include_once('inc/footer.inc.php'); ?>
		</div>
	</body>
</html>