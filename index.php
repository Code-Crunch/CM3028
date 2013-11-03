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
	<?php
		$adminUsername = 'admin';
		$adminPassword = '123';
		$userlist = 'encrypted.txt';
		$error = array();
		$loginRequested = isset( $_POST['login']); //boolean
		$logoutRequested = isset( $_GET['logout'] ); //boolean

		if($logoutRequested) {
			require_once('inc/logout.inc.php');
		}

		if( $loginRequested ) {	
			require_once('inc/login.inc.php');	
		}
	?>
	<div id="textbooksApp-main">

    	<!-- keyword search -->
    	<fieldset class="keywordSearch">
   			<input class="keywordSearch__input"></input>
   			<a id="search" class="keywordSearch__search btn">Search &gt;</a>
   		</fieldset>
    	<!-- /keyword search -->

    	<?php
     	if( !empty($error) ) {
		 	echo '<ul class="loginError">';
		 	foreach ($error as $key => $value) {
		 		echo '<li>' . $value . '</li>';
		 	}
		 	echo '</ul>';
		}
		?>

    	<?php
		if( !isset( $_SESSION['currentUser']) ) {
			include_once('inc/login_form.inc.php');
			
		} else {
			include_once('inc/logout_form.inc.php');
		}
    	?>

    	<div class="innerWrapper">

    	<h1 class="title">School of Computing Science &amp; Digital Media</h1>
    	<h2 class="subtitle">Current session: 2013/14</h2>

    	<p class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te.</p>

    	<!-- choices -->
    	<fieldset class="choices">
    		<div class="choices-option">
			<label class="choices__course">Course</label>
			<div class="choices__select">
				<div class="select">
					<select class="choices__course">
						<option value="">Select...</option>
						<option value="CS">Computer Science, BSc.</option>
						<option value="IM">Internet and Multimedia, BSc.</option>
					</select>
				</div>
			</div>
			</div>
			<!-- /course -->

			<div class="choices-option">
				<label class="choices__year">Course year</label>
				<div class="choices__select">
					<div class="select">
						<select class="choices__year">
							<option value="">Select...</option>
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
						<select class="choices__module">
							<option value="">Select...</option>
							<option value="cm101">CM101</option>
							<option value="cm102">CM102</option>
							<option value="cm103">CM103</option>
							<option value="cm104">CM104</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /module -->

		<a href="courses.php" id="browseDatabase" class="choices__browse btn"></a>
		<!-- /submit the form -->
		</fieldset>
		<!-- /choices -->

	</div>

	<?php include_once('inc/footer.inc.php'); ?>

   </div>

</body>
</html>
