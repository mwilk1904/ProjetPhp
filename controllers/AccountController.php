<?php
class AccountController{

    private $_db;

    public function __construct($db) {
      $this->_db = $db;
    }

	public function run(){
      if (empty($_SESSION['authentificate'])) {
              header("Location: index.php?action=home");
              die();
          }

        $errors=array();
        $notif=array();

        #if user want to change his password
        if(!empty($_POST['form_passwd'])){
            if (!empty(trim($_POST['oldpasswd'])) && !empty(trim($_POST['newpasswd'])) && !empty(trim($_POST['confirmpasswd']))) {
                if($_POST['newpasswd'] != $_POST['confirmpasswd']){
                    $errors[]= "Les 2 mots de passe ne corespondent pas";
                }
                if(!password_verify($_POST['oldpasswd'],$this->_db->select_passwd($_SESSION['login']))){
                    $errors[] = "L'ancien mot de passe n'est pas bon";
                }
                else{
                    $hash = password_hash($_POST['newpasswd'], PASSWORD_BCRYPT);
                    $this->_db->update_passwd($_SESSION['login'],$hash);
                    $notif[] = "Le mot de passe a été modifié avec succès !";
                }
            }
        }

        #if user want to change his profile
        if(!empty($_POST['form_profile'])){
            if(empty(trim($_POST['email'])) ||
            (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $_POST['email']))==0){
                $errors[] = "L'email est invalide";
            }
            if (empty(trim($_POST['phone'])) ||
            (preg_match("/^0[0-9]{9}$/", $_POST['phone']))==0) {
                $errors[] = "Le numéro de téléphone invalide";
            }

            if (empty(trim($_POST['address']))) {
                $errors[] = "L'adresse postale invalide";
            }

            if (empty(trim($_POST['bank']))) {
                $errors[] = "Le numéro de compte en banque est invalide";
            }
            elseif(empty($errors)){
                $this->_db->update_profile($_SESSION['login'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['bank']);
                $notif[] = "Le profil a été modifié !";
            }
        }

        #if user want to change his image
        if(!empty($_POST['form_image'])){
            if(empty($_FILES['image']['tmp_name'])){
                $errors[] = "La photo n'est pas valide";
            }

            if (($_FILES['image']['size'] > 1000000)) {
                $errors[] = "La photo est trop lourde.";
            }

            if ($_FILES['image']['type'] != 'image/jpeg' &&  $_FILES['image']['type']!='image/png') {
                $errors[] = "La format de la photo n'est pas bon";
            }

            if($_FILES['image']['size']!=0 && getimagesize($_FILES['image']['tmp_name'])['mime']!= 'image/jpeg' &&
            getimagesize($_FILES['image']['tmp_name'])['mime']!='image/png'){
                $errors[] = "La format de la photo n'est pas bon";
            }

            else {
                $origin = $_FILES['image']['tmp_name'];
                $temp = explode(".", $_FILES['image']['name']); #keep the extension of the picture
                $destination = 'views/images/profile_pictures/'.$_SESSION['login'].'_picture'.'.'.end($temp);
                move_uploaded_file($origin,$destination);
                $this->_db->update_profile_picture($_SESSION['login'],$_SESSION['login'].'_picture'.'.'.end($temp));
                $notif[] = "La photo de profil a été modifié avec succès !";
            }
        }
        $info_member=$this->_db->select_member($_SESSION['login']);

		require_once(VIEWS_PATH . 'account.php');
	}

}
?>
