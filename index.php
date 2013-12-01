<?php
	session_start();
	ob_start();
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
		<?php
			$loginDetails = 'login_details_encrypted.txt';
			$error = array();
			$loginRequested = isset( $_POST['login']); //boolean
			$logoutRequested = isset( $_GET['logout'] ); //boolean
	
			require_once('inc/get_login_details.inc.php');
	
			if($logoutRequested) {
				require_once('inc/logout.inc.php');
			}
	
			if( $loginRequested ) {	
				require_once('inc/login.inc.php');	
			}
		?>
		<div id="textbooksApp-main">
	
			<!-- keyword search -->
			<form id="search" method="get" action="">
				<fieldset class="keywordSearch">
					<input class="keywordSearch__input"></input>
					<input type="submit" name="search" class="keywordSearch__search btn" value="Search &gt;">
				</fieldset>
			</form>
			<!-- /keyword search -->
		
			<?php
				if( !empty($error) ) {
					echo '<ul class="loginError">';
					foreach ($error as $key => $value) {
						echo '<li>' . $value . '</li>';
					}
					echo '</ul>';
				}

				if( !isset( $_SESSION['currentUser']) ) {
					include_once('inc/login_form.inc.php');
				} else {
					include_once('inc/logout_form.inc.php');
				}
			?>
		
			<div class="innerWrapper">
				<h1 class="title">School of Computing Science &amp; Digital Media</h1>
				<h2 class="subtitle">Current session: 2013/14</h2>
			
				<p class="description">Welcome to CodeCrunch's book searching web application!<br/>To start searching for a book you can either select a course, year or module from the drop down menus and then click search, you will then be shown all the books either in that course, year or module. For a more specific search try selecting an option from more than one of the drop down menus to give all the books that match your input criteria. Alternatively you can do an advance search where you can enter full or partial keywords and that will show you all books that have that matching keyword.</p>
		
				<!-- choices -->
				<?php
					$searchSubmitted = isset( $_GET['browseDatabase']); //boolean
				
					if($searchSubmitted) {
				// START of Sam Cussons code
						if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) { 
							if ($_GET['courses'] == "select-course" && $_GET['modules'] == "select-module") {
								// Nothing set so COURSES.PHP
								header('Location: courses.php');
								exit;
							} else if ($_GET['courses'] != "select-course" && $_GET['years'] != "select-year" && $_GET['modules'] != "select-module"){
								// Course, Module and Year SET so BOOKS.PHP
								header("Location: books.php?courses=".$_GET['courses']."&years=".$_GET['years']."&modules=".$_GET['modules']);
								exit;
							} else if ($_GET['courses'] != "select-course" && $_GET['years'] != "select-year" && $_GET['modules'] == "select-module"){
								// Course and Year Set MODULES.PHP
								header("Location: modules.php?courses=".$_GET['courses']."&years=".$_GET['years']);
								exit;
							} else if ($_GET['courses'] != "select-course" && $_GET['years'] == "select-year" && $_GET['modules'] == "select-module"){
								// Course Set YEARS.PHP
								header("Location: years.php?courses=".$_GET['courses']);
								exit;
							} else if ($_GET['courses'] == "select-course" && $_GET['years'] == "select-year" && $_GET['modules'] != "select-module"){
								// Module Set BOOKS.PHP
								header("Location: books.php?courses=".$_GET['courses']."&years=".$_GET['years']."&modules=".$_GET['modules']);
								exit;
							} else if ($_GET['courses'] != "select-course" && $_GET['modules'] != "select-module"){
								// Module Set BOOKS.PHP
								header("Location: books.php?courses=".$_GET['courses']."&years=".$_GET['years']."&modules=".$_GET['modules']);
								exit;
							}
						} else {
							header('Location: books.php');
							exit;
						}
					}
				?>
				<?php
					if(isset($_SESSION['currentUser']) && $_SESSION['currentAccessLevel'] == 1) {
						echo "<form id=\"choices\" method=\"get\" action=\"\">";
					} else {
						echo "<form id=\"choices\" method=\"get\" action=\"books.php\">";
					}
				?>
				<!-- End of Sam Cussons code -->
				<fieldset class="choices">
					<div class="choices-option">
						<label class="choices__course">Course</label>
						<div class="choices__select">
							<div class="select">
								<select id="courses" name="courses" class="choices__course">
									<option value="select-course">Select...</option>
									<!-- Start of Sam Cussons code -->
									<?php
										try {
											$dsn = "mysql:host=localhost;dbname=".$mysqldatabase;
											// try connecting to the database
											$conn = new PDO($dsn, $mysqlusername, $mysqlpassword);
											// turn on PDO exception handling 
											$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										} catch (PDOException $e) {
											// enter catch block in event of error in preceding try block
											echo "Connection failed: ".$e->getMessage();
										}
										try {
											$sql="SELECT * FROM courses";
											$results=$conn->query($sql);
											if ($results->rowcount()==0){
												echo "No results <br/>";
											} else {
												//generate table of results
												foreach ($results as $row){
													echo "<option value=\"".$row['CID']."\">".$row['title']."</option>";
												}
											}
										} catch ( PDOException $e ) {
											echo "Query failed: " . $e->getMessage();
										}
										$conn = null;
									?>
									<!-- End of Sam Cussons code -->
								</select>
							</div>
						</div>
					</div>
					<!-- /course -->
			
					<div class="choices-option">
						<label class="choices__year">Course year</label>
						<div class="choices__select">
							<div class="select">
								<select class="choices__year" name="years" id="years" >
									<option value="select-year">Select...</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</div>
						</div>
					</div>
					<!-- /year -->
					<div class="choices-option">
						<label class="choices__module">Module</label>
						<div class="choices__select">
							<div class="select">	
								<select class="choices__module" name="modules" id="modules">
									<option value="select-module">Select...</option>
									<!-- Start of Sam Cussons code -->
									<?php
										try {
											$dsn = "mysql:host=localhost;dbname=".$mysqldatabase;
											// try connecting to the database
											$conn = new PDO($dsn, $mysqlusername, $mysqlpassword);
											// turn on PDO exception handling 
											$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										} catch (PDOException $e) {
											// enter catch block in event of error in preceding try block
											echo "Connection failed: ".$e->getMessage();
										}
										try {
											$sql="SELECT * FROM modules";
											$results=$conn->query($sql);
											if ($results->rowcount()==0){
												echo "No results <br/>";
											} else {
												//generate table of results
												foreach ($results as $row){
												    echo "<option value=\"".$row['MID']."\">".$row['title']."</option>";
												}
											}
										} catch ( PDOException $e ) {
											echo "Query failed: " . $e->getMessage();
										}
										$conn = null;
									?>
									<!-- End of Sam Cussons code -->
								</select>
							</div>
						</div>
					</div>
					<!-- /module -->
					
					<input type="submit" name="browseDatabase" class="choices__browse btn" value="">
			
					<!-- /submit the form -->
					</fieldset>
				</form>
				<!-- /choices -->
		
			</div>
		
			<?php include_once('inc/footer.inc.php'); ?>
		
		</div>
	</body>
</html>
