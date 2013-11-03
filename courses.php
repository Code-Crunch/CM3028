<!-- Marina Shchukina, 1014481 
	BEM methodology is behind all the html elements naming conventions
	http://bem.info/method/
-->
<?php
	session_start();
?>
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
					<tr>
						<td class="wide"><a href="years.php">Computer Science</a></td>
						<td>1</td>
						<td>4</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td class="wide"><a href="years.php">Internet and Web Development</a></td>
						<td>3</td>
						<td>2</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td class="wide"><a href="years.php">Project Management in Computing</a></td>
						<td>1</td>
						<td>4</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
					<tr>
						<td class="wide"><a href="years.php">Game Development</a></td>
						<td>3</td>
						<td>2</td>
						<td><a href="#">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
				</tbody>

			</table>

			<?php
				if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) { 
					include_once('inc/add_button.inc.php');
				}

			?>

		</div>

		<?php include_once('inc/footer.inc.php'); ?>
	</div>
</body>
</html>