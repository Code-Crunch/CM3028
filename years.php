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
					<tr>
						<td><a href="modules.php">1</a></td>
					</tr>
					<tr>
						<td>2</td>
					</tr>
					<tr>
						<td>3</td>
					</tr>
					<tr>
						<td>4</td>
					</tr>
				</tbody>

			</table>

		</div>

		<?php include_once('inc/footer.inc.php'); ?>
	</div>
</body>
</html>