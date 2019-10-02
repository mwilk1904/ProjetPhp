<?php
	# Activate the mecanism of session
	session_start();


	#PHPMailer
	require 'lib/PHPMailer/src/Exception.php';
	require 'lib/PHPMailer/src/PHPMailer.php';
	require 'lib/PHPMailer/src/SMTP.php';

	#config.proprietes
	$fp= fopen("conf/config.properties","r");
	while (!feof($fp)) {
		$line=fgets($fp,4000);
		$array=explode("=",$line); #same as function split() in java

		if($array[0]=='mysql_host') define('MYSQL_HOST',trim($array[1]));
		if($array[0]=='dbname') define('DB_NAME',trim($array[1]));
		if($array[0]=='charset') define('CHARSET',trim($array[1]));
		if($array[0]=='group') define('GROUP_NAME',trim($array[1]));
		if($array[0]=='city') define('CITY_NAME',trim($array[1]));
		if($array[0]=='bank_account') define('BANK_ACCOUNT',trim($array[1]));
		if($array[0]=='contact_name') define('CONTACT_NAME',trim($array[1]));
		if($array[0]=='contact_first_name') define('CONTACT_FIRST_NAME',trim($array[1]));
		if($array[0]=='contact_email') define('CONTACT_EMAIL',trim($array[1]));
		if($array[0]=='contact_phone') define('CONTACT_PHONE',trim($array[1]));
		if($array[0]=='picture') define('GROUP_PICTURE',trim($array[1]));
	}
	fclose($fp);


	# Global Constants
	define('VIEWS_PATH','views/');
	define('CONTROLLERS_PATH','controllers/');
	define('DATEDUJOUR',date("j/m/Y"));

	# Automatic load for the class in models/
	function chargeClass($class) {
		require_once 'models/' . $class . '.class.php';
	}
	spl_autoload_register('chargeClass');

	# Connection to the db
	$db=Db::getInstance();

	$cal='yes';
	if (!empty($_GET['cal']) && $_GET['cal']=='no') {
		$cal='no';
	}
	# For the header : admin,member or surfer
	if ($cal=='yes') {
		if (empty($_SESSION['authentificate'])){
			require_once(VIEWS_PATH.'header_surfer.php');
		}
		elseif (!empty($_SESSION['duty']) && $_SESSION['duty'] == 'm' ) {
			require_once(VIEWS_PATH.'header_member.php');
		}

		else{
			require_once(VIEWS_PATH.'header_admin.php');
		}
	}

	# Test if a variable GET 'action' is precised in the URL index.php?action=...
	$action = (isset($_GET['action'])) ? $_GET['action'] : 'default';
	# Asked action in the URL ?
	switch($action) {

		case 'login':
			require_once(CONTROLLERS_PATH.'HomeController.php');
			$controller = new HomeController($db);
			break;

		case 'logout':
			require_once(CONTROLLERS_PATH.'LogoutController.php');
			$controller = new LogoutController();
			break;

		case 'event':
			require_once(CONTROLLERS_PATH.'EventController.php');
			$controller = new EventController($db);
			break;

		case 'account':
			require_once(CONTROLLERS_PATH.'AccountController.php');
			$controller = new AccountController($db);
			break;

		case 'training':
			require_once(CONTROLLERS_PATH.'TrainingController.php');
			$controller = new TrainingController($db);
			break;

		case 'admin':
			require_once(CONTROLLERS_PATH.'AdminController.php');
			$controller = new AdminController($db);
			break;

		case 'calendar':
			require_once(CONTROLLERS_PATH.'CalendarController.php');
			$controller = new CalendarController($db);
			break;

		default: # default controller
			require_once(CONTROLLERS_PATH.'HomeController.php');
			$controller = new HomeController($db);
			break;
	}
	# Execute the asked controller
	$controller->run();

	# Footer of all pages
	if ($cal=='yes') {
		require_once(VIEWS_PATH . 'footer.php');
	}

?>
