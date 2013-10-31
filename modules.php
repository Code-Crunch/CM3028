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

			<h1 class="tableTitle">Modules</h1>

			<!-- Table markup-->

			<table class="databaseResults">

			<!-- Table header -->
	
			<thead>
				<tr>
					<th scope="col">Module Code</th>
					<th scope="col">Module Title</th>
					<th scope="col">Module Description</th>
					<th scope="col"></th>
					<th scope="col"></th>
					
				</tr>
			</thead>
	
	
			<!-- Table body -->
			
				<tbody>
					<tr>
						<td>CM101</td>
						<td><a href="books.php">Introduction to PHP</a></td>
						<td>Lorem ipsum sit amet</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td>CM102</td>
						<td class="medium"><a href="books.php">PHP for dummies</a></td>
						<td class="medium">Lorem ipsum sit amet</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td>CM103</td>
						<td class="medium"><a href="books.php">PHP Advanced</a></td>
						<td class="medium">Lorem ipsum sit amet</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td>CM104</td>
						<td class="medium"><a href="books.php">PHP Intermediate</a></td>
						<td class="medium">Lorem ipsum sit amet</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
				</tbody>

			</table>

			<?php include_once('inc/add_button.inc.php'); ?>
			<?php include_once('inc/show_lonely_modules_button.inc.php'); ?>

		</div>

		<?php include_once('inc/footer.inc.php'); ?>
	</div>
</body>
</html>