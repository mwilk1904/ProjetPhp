<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset=<?php echo CHARSET ?> >
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Runner</title>
		<link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH ?>css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH ?>css/style.css">
	</head>
		<body>
			<header>
				<nav class="navbar navbar-dark navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand-xs" id = "navbar">
				  <a class="navbar-brand" href="?action=home">Runner<img src="<?php echo VIEWS_PATH ?>images/runner.gif" alt="images" height="50" width="50"></a>
				  	 <ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php?action=home"> Accueil </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?action=training&amp;training_id=<?php echo $_SESSION['following_training'] ?>"> Entrainement </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?action=event"> Evenement </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?action=account"> Mon compte </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?action=logout"> Se deconnecter </a>
						</li>
			  		</ul>
				</nav>
			</header>
