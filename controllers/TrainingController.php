<?php
class TrainingController{

    private $_db;

    public function __construct($db) {
      $this->_db = $db;
    }

	public function run(){
        if (empty($_SESSION['authentificate'])) {
                header("Location: index.php?action=home");
                die();
        }
        $error = array();
        $notif = array();
        $array_training_days = array();
        $training_id='';
        $array_members_training = array();

        if(!empty($_GET['training_id']) && $this->_db->verify_training_id($_GET['training_id'])){

            if(!empty($_POST['form_button'])){
                if($this->_db->exist_followed_training($_SESSION['login'],$_GET['training_id'])){
                    $this->_db->update_following_date($_SESSION['login'],$_GET['training_id']);
                    $_SESSION['following_training'] = $_GET['training_id'];
                }
                else{
                    $this->_db->insert_member_training($_SESSION['login'],$_GET['training_id']);
                    $_SESSION['following_training'] = $_GET['training_id'];
                }
            }

            elseif(!empty($_POST['form_del'])){
                $this->_db->delete_all_training_days($_GET['training_id']);
                $this->_db->delete_all_members_training($_GET['training_id']);
                $this->_db->delete_training($_GET['training_id']);
                $_SESSION['following_training'] = $this->_db->select_followed_training($_SESSION['login']);
                $redirect = "Location: index.php?action=training&training_id=".$_SESSION['following_training'];
                header($redirect);
                die();
            }

            elseif (!empty($_POST['form_change'])) {
                if(!empty($_POST['array_date'])){
                    $array_descriptive = $_POST['text_descriptive'];
                    $array_date = $_POST['array_date'];
                    foreach ($array_date as $i => $date) {
                        $this->_db->update_training_day($_GET['training_id'],$date,$array_descriptive[$i]);
                    }

                }
            }

            elseif (!empty($_POST['form_add_day'])) {
                if(empty(trim($_POST['add_activity']))){
                    $errors[] = "Veuillez entrer une activité";
                }
                if (empty(trim($_POST['add_date']))) {
                    $errors[] = "Veuillez entrer une date";
                }

                if(!strtotime($_POST['add_date'])){
                    $errors[] = "la date n'est pas valide";
                }
                elseif(empty($errors)){
                    $temp_date = date('Y-m-d', strtotime($_POST['add_date'])); #change to american date
                    $this->_db->insert_training_days($_GET['training_id'],$_POST['add_activity'],$temp_date);
                }
            }

            elseif (!empty($_POST['form_export'])){
                $redirect = "Location: index.php?action=calendar&cal=no&training_id=".$_GET['training_id'];
                header($redirect);
                die();
            }

            elseif (!empty($_POST['form_import'])) {
                if ($_FILES['csv']['type']!='application/vnd.ms-excel'){
                    $errors[] = "Le format du fichier n'est pas bon";
                }

                if(empty($_FILES['csv']['tmp_name'])){
                        $errors[] = "Veuillez entrer un fichier valide";
                    }

                elseif(empty($errors)){
                    $this->_db->import_training_days($_GET['training_id'],$_FILES['csv']['tmp_name']);
                    $notif[] = "<p class=notification-green>Le fichier a été importé !";
                }

            }

            $array_training_days = $this->_db->select_training_days($_GET['training_id']);
            $array_members_training = $this->_db->select_members_training($_GET['training_id']);
        }

        elseif(!empty($_POST['form_add'])){
            if(empty(trim($_POST['add_training']))){
                $errors[] = "Veuillez entrer un nom d'entrainement valide";
            }

            else{
                $temp = $this->_db->insert_training($_POST['add_training']);
                $notif[] = "L'entrainement a été ajouté !";
                $redirect = "Location: index.php?action=training&training_id=".$temp;
                header($redirect);
                die();
            }
        }


        $array_training = $this->_db->select_all_training();

        if($_SESSION['duty'] != 'c') require_once(VIEWS_PATH . 'training_member.php');
        else require_once(VIEWS_PATH . 'training_coach.php');
    }
}
?>
