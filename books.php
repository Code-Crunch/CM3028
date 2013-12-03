<?php
	session_start();
	require_once "inc/database.inc.php";
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
				if ($_GET['courses'] == "orphans" && $_GET['years'] == "orphans" && $_GET['modules'] == "orphans") {
					$orphs = true;
				}
				if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1 && !$orphs && $_GET['pOrph'] != "yes") {
					echo "<a href=\"modules.php?courses=".$_GET['courses']."&years=select-year\" class=\"btn\">&lt; Back</a>";
				} else {
					echo "<a href=\"index.php\" class=\"btn\">&lt; Home</a>";
				}
			?>
			<!-- End of Sam Cussons code -->
		</fieldset>
		<div class="innerWrapper">
			<h1 class="tableTitle">Books</h1>

			<!-- Table markup-->
			<table class="databaseResults">

			<!-- Table header -->
			<thead>
				<tr>
					<th scope="col">Book Title</th>
					<th scope="col">First author's name</th>
					<th scope="col">Second author's name</th>
					<th scope="col">Publisher</th>
					<th scope="col">Year of publication</th>
					<th scope="col">Subject content</th>
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
							$modules = htmlentities($_GET['modules']);
							$years = htmlentities($_GET['years']);
							
							
							$sql="SELECT books.bid, books.title, books.author1, books.author2, books.publisher, books.year, books.keyword
								FROM books
								LEFT JOIN moduleBooks ON books.bid = moduleBooks.bid
								LEFT JOIN courseModules ON moduleBooks.mid = courseModules.mid ";
							if ($courses == "select-course" && $modules == "select-module") {
								// Nothing set so BOOKS.PHP
								echo "<tr><td>Nothing Selected</td></tr>";
							} else if ($courses != "select-course" && $years != "select-year" && $modules != "select-module"){
								// Course, Module and Year SET so BOOKS.PHP
								$sql = $sql. "WHERE courseModules.cid =  \"".$courses."\" AND moduleBooks.mid = \"".$modules."\" AND courseModules.year = \"".$years."\"" ;
							} else if ($courses != "select-course" && $years != "select-year" && $modules == "select-module"){
								// Course and Year Set MODULES.PHP
								$sql = $sql. "WHERE courseModules.cid =  \"".$courses."\" AND courseModules.year = \"".$years."\"" ;
							} else if ($courses != "select-course" && $years == "select-year" && $modules == "select-module"){
								// Course Set YEARS.PHP
								$sql = $sql. "WHERE courseModules.cid =  \"".$courses."\"" ;
							} else if ($courses == "select-course" && $years == "select-year" && $modules != "select-module"){
								// Module Set BOOKS.PHP
								$sql = $sql. "WHERE moduleBooks.mid = \"".$modules."\"" ;
							} else if ($courses != "select-course" && $modules != "select-module"){
								// Module and Courses Set BOOKS.PHP
								$sql = $sql. "WHERE courseModules.cid =  \"".$courses."\" AND moduleBooks.mid = \"".$modules."\"" ;
							}
							$sql = $sql." ORDER BY books.title";
							if ($courses == "orphans" && $years == "orphans" && $modules == "orphans" && isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {
								$sql="SELECT books.bid, books.title, books.author1, books.author2, books.publisher, books.year, books.keyword
									FROM books
									LEFT OUTER JOIN moduleBooks ON moduleBooks.bid = books.bid
									WHERE moduleBooks.bid IS NULL ";
							}
							
							
							$stmt = $conn->prepare($sql);
							if ($stmt->execute(array())) {
								while ($row = $stmt->fetch()) {
									echo "<tr>";
									echo "<td>".$row['title']."</td>";
									echo "<td>".$row['author1']."</td>";
									echo "<td>".$row['author2']."</td>";
									echo "<td>".$row['publisher']."</td>";
									echo "<td>".$row['year']."</td>";
									echo "<td>".$row['keyword']."</td>";
									if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {
										echo "<td><a href=\"inc/bookEdit.inc.php?books=".$row['bid']."\">Edit</a></td>";
										if ($courses == "orphans" && $years == "orphans" && $modules == "orphans") {
											echo "<td><a href=\"inc/delete.inc.php?books=".$row['bid']."\">Delete</a></td>";
										}
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
					echo "<a class=\"btn-extras\" href=\"inc/bookAdd.inc.php\">Add</a>";
					include_once('inc/show_lonely_books_button.inc.php');
				}
			?>
		</div>
		<?php include_once('inc/footer.inc.php'); ?>
	</div>
</body>
</html>
