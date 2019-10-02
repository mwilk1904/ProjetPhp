<?php
class HomeController{

	private $_db;

    public function __construct($db) {
      $this->_db = $db;
    }

	public function run(){
		$array_futur_events = $this->_db->select_futur_events();
		$errors=array(); #An array of errors than can occur when someone is trying to sign up
		$notification=array();

		#++++++++++++++++++++++++++++++++++++++++++
		#-----------------Sign in------------------
		#++++++++++++++++++++++++++++++++++++++++++

		if (!empty($_POST['connection'])){
			if(!empty($_POST['login']) && !empty($_POST['password'])){
				if(!$this->_db->login_exists($_POST['login'])){
	 				$errors[]=' Votre login n\'existe pas ';
			} elseif (!$this->_db->validate_member($_POST['login'],$_POST['password'])) {
					$errors[]=' Votre mot de passe n\'est pas correct. ';
			} elseif ($this->_db->select_member($_POST['login'])->validate()==0) {
				$errors[]='  Votre inscription est en attente de validation. Vous ne pouvez pas vous connecter pour le moment. ';
			} else {
				$_SESSION['authentificate'] = true;
				$_SESSION['login'] = $_POST['login'];
				$member=$this->_db->select_member($_SESSION['login']);
				$_SESSION['duty'] = $member->duty();
				$_SESSION['following_training'] = $this->_db->select_followed_training($_SESSION['login']);
				header("Location: index.php?action=home");
				die();
			}
		 }
		}


		#++++++++++++++++++++++++++++++++++++++++++++
		#------------------Sign up-------------------
		#+++++++++++++++++++++++++++++++++++++++++++++


		 if(!empty($_POST['form_add_user'])){
			 if(empty(trim($_POST['login_sign_up']))){
				 	$errors[]='Le champ login est vide.';
			 }
			 if(empty(trim($_POST['name']))){
				 $errors[]='Le champ nom est vide.';
			 }
			 if(empty(trim($_POST['first_name']))){
				 $errors[]='Le champ prenom est vide.';
			 }
			 if(empty($_POST['email'])){
				 $errors[]='Le champ email est vide.';
			 }
			 if(empty(trim($_POST['bank_account']))){
				 $errors[]='Le champ numero de compte en banque est vide.';
			 }
			 if(empty(trim($_POST['address']))){
				 $errors[]='Le champ adresse est vide.';
			 }
			 if(empty(trim($_POST['password1'])) && !empty(trim($_POST['password2']))){
				 $errors[]='Les champs de mots de passe ne sont pas complets.';
			 }
			 if($this->_db->login_exists($_POST['login_sign_up'])){
				  $errors[]=' Votre login est deja utilisé. Veuillez en choisir un autre. ';
			 }
			 if (strcmp($_POST['password1'], $_POST['password2']) !=0 ) {
				 	$errors[]=' Attention, les deux mots de passe ne sont pas les mêmes. ';
			 }
			 if (!preg_match ( " /^.+\@.+\..+$/ " ,$_POST['email'])) {
				  $errors[]=' Votre email n\'est pas conforme. ';
			 }
			 if (!preg_match(" /^[0-9]{10}$/ ",$_POST['phone'])) {
			 		$errors[]=' Le numero de téléphone doit contenir exactement 10 chiffres. ';
				}

				elseif(empty($errors)) {
				 		if (empty($_FILES['photo']['tmp_name'])){
					 		$this->_db->insert_member($_POST['login_sign_up'],password_hash($_POST['password1'], PASSWORD_BCRYPT),$_POST['name'],$_POST['first_name'],$_POST['phone'],$_POST['email'],$_POST['bank_account'],$_POST['address'],'default.jpg','m',0,null);
					 		$this->_db->insert_member_training($_POST['login_sign_up'],1); #new user will follow the base training
					 		$notification[]= '  Vous avez été ajouté à la liste d\'attente. Un responsable va traiter votre demande et un email vous sera transmis d\'ici peu. ';
						} else {
							 		$pictureinfo = getimagesize($_FILES['photo']['tmp_name']);
							 		if (($_FILES['photo']['type']=='image/jpeg' && $pictureinfo['mime']=='image/jpeg') || ($_FILES['photo']['type']=='image/png' && $pictureinfo['mime']=='image/png')) {
										 $origin = $_FILES['photo']['tmp_name'];
										 $temp = explode(".", $_FILES['photo']['name']); #keep the extension of the picture
										 $destination = VIEWS_PATH.'images/profile_pictures/'.$_POST['login_sign_up'].'_picture'.'.'.end($temp);
										 move_uploaded_file($origin,$destination);
										 $picture=$_POST['login_sign_up'].'_picture'.'.'.end($temp);
										 $this->_db->insert_member($_POST['login_sign_up'],password_hash($_POST['password1'], PASSWORD_BCRYPT),$_POST['name'],$_POST['first_name'],$_POST['phone'],$_POST['email'],$_POST['bank_account'],$_POST['address'],$picture,'m',0,null);
										 $this->_db->insert_member_training($_POST['login_sign_up'],1); #new user will follow the base training
										 $notification[]= '  Vous avez été ajouté à la liste d\'attente. Un responsable va traiter votre demande et un email vous sera transmis d\'ici peu. ';
					 			 	} else {
						 					$errors[]= ' Le fichier uploadé doit être une image .jpg ou .png ! ';
					 				}
				 		}
			 	}
		 }


	 if (!empty($_SESSION['login'])){
		 $array_training_week = $this->_db->select_training_days_of_week($_SESSION['following_training']);
	 }




		if(empty($_SESSION['authentificate'])){
			require_once(VIEWS_PATH . 'home_surfer.php');
		}
		else{
			require_once(VIEWS_PATH . 'home_member.php');
		}
	}

}
?>
