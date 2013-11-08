<?php
	session_start();
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
			<a href="years.php" class="btn">&lt; Back</a>
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
					<tr>
						<td>PHP Cookbook</td>
						<td>Joe Doe</td>
						<td>Jane Doe</td>
						<td>aPress</td>
						<td>2008</td>
						<td>PHP, beginners, MySQL</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
				</tbody>

			</table>

			<?php 
			if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) { 
				include_once('inc/add_button.inc.php');
				include_once('inc/show_lonely_books_button.inc.php');
			} 
			?>

		</div>

		<?php include_once('inc/footer.inc.php'); ?>
	</div>
</body>
</html>
