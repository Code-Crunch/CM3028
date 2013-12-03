<?php
	session_start();
	require_once "inc/database.inc.php";
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
		<div id="textbooksApp-modules">
			<fieldset class="back">
				<!-- Start of Sam Cussons code -->
				<?php
					$orphs=false; //MS
					if ($_GET['courses'] == "orphans" && $_GET['years'] == "orphans") {
						$orphs = true;
					}
					if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1 && !$orphs) {
						echo "<a href=\"years.php?courses=".$_GET['courses']."&years=select-year\" class=\"btn\">&lt; Back</a>";
					} else {
						echo "<a href=\"index.php\" class=\"btn\">&lt; Home</a>";
					}
				?>
				<!-- End of Sam Cussons code -->
			</fieldset>
	
			<div class="innerWrapper">
				<h1 class="tableTitle">Modules</h1>
	
				<!-- Table markup-->
				<table class="databaseResults">
	
				<!-- Table header -->
					<thead>
						<tr>
							<th scope="col">Module ID</th>
							<th scope="col">Module Title</th>
							<th scope="col">Module Description</th>
							
							<th scope="col"></th>
							<th scope="col"></th>
						</tr>
					</thead>
					
					<!-- Table body -->
					<tbody>
						<!-- Start of Sam Cussons code -->
						<?php
							try {
								$courses = htmlentities($_GET['courses']);
								$years = htmlentities($_GET['years']);
								
								if ($years == "select-year") {
									$sql="SELECT modules.mid, modules.title, modules.descr
										FROM modules
										LEFT JOIN courseModules ON modules.mid = courseModules.mid
										WHERE courseModules.CID = \"".$courses."\"
										ORDER BY modules.title";
								} else {
									$sql="SELECT modules.mid, modules.title, modules.descr
										FROM modules
										LEFT JOIN courseModules ON modules.mid = courseModules.mid
										WHERE courseModules.CID = \"".$courses."\" AND courseModules.year = \"".$years."\"
										ORDER BY modules.title";
								}
								if ($courses == "orphans" && $years == "orphans") {
									$sql="SELECT modules.mid, modules.title, modules.descr
										FROM modules
										LEFT OUTER JOIN courseModules ON courseModules.mid = modules.mid
										WHERE courseModules.mid IS NULL "
									;
								}
								
								$stmt = $conn->prepare($sql);
                                                                if ($stmt->execute(array())) {
									if (!$orphs) {
										echo "<tr><td><a href=\"books.php?courses=".$courses."&years=".$years."&modules=select-module\">All</a></td></tr>";
									}
									while ($row = $stmt->fetch()) {
										echo "<tr>";
										echo "<td><a href=\"books.php?courses=select-course&years=select-year&pOrph=yes&modules=".$row['mid']."\">".$row['mid']."</td>";
										echo "<td>".$row['title']."</a></td>";
										echo "<td>".$row['descr']."</td>";
										echo "<td><a href=\"inc/moduleEdit.inc.php?modules=".$row['mid']."\">Edit</a></td>";
										if ($orphs) {
											echo "<td><a href=\"inc/delete.inc.php?modules=".$row['mid']."\"&pCourse=".$courses."\"pYear=".$years."\">Delete</a></td>";
										}
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
					echo "<a class=\"btn-extras\" href=\"inc/moduleAdd.inc.php\">Add</a>";
						include_once('inc/show_lonely_modules_button.inc.php');
					} 
				?>
			</div>
			<?php include_once('inc/footer.inc.php'); ?>
		</div>
	</body>
</html>
