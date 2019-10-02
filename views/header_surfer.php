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
			  <a class="navbar-brand" href="?action=home">Runner</a>
			  	 <div class="navbar-nav">
					 <form class="form-inline " action="index.php?action=login" method="post">
						<input name="login" class="form-control mr-sm-2" type="text" placeholder="Nom de compte">
						<input name="password" class="form-control mr-sm-2" type="password" placeholder="Mot de passe">
						<input class="btn btn-success mr-sm-2" type="submit" name="connection" value="Connexion">
					</form>
			    </div>
			</nav>
		</header>
