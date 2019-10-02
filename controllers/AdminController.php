<?php
class AdminController{
  private $_db;
  private $_raw_html;

	public function __construct($db) {
		$this->_db = $db;
    $this->_raw_html='';
	}
  public function run(){
    $notification=array();
    $errors=array();

    if (empty($_SESSION['authentificate']) || $_SESSION['duty']=='m') {
			header("Location: index.php?action=home");
			die();
		}


    if(!empty($_POST['form_validate'])){
      if (!empty($_POST['invalide_members'])) {
				foreach ($_POST['invalide_members'] as $i => $login) {
					$this->_db->change_validate($login,1);
				}
				$notification[] = ' Le(s) membre(s) en attente ont été validé(s) ';
			} else {
				$errors[] = ' Les membres n\'ont pas été validés ';
			}
    }

    if(!empty($_POST['form_change_duty'])){

      if(!empty($_POST['duty_list'])){
        $array_members=$this->_db->select_members();
        foreach ($_POST['duty_list'] as $i => $duty) {
          if($this->_db->number_of_responsible_member()>1 || $duty!="m'"){
            switch ($duty) {
              case "Membre":
                $duty="m";
                break;
              case "Membre Responsable":
                $duty="r";
                break;
              case "Coach":
                $duty="c";
                break;
            }
              $this->_db->change_duty($array_members[$i]->html_login(), $duty);
          } else {
            $errors[]='Changement impossible. Il doit y avoir au moins un membre responsable ou coach! ';
          }

        }
        $member=$this->_db->select_member($_SESSION['login']);
        if($_SESSION['duty']!= $member->html_duty()){
          $_SESSION['duty'] = $member->html_duty();
          header("Location: index.php?action=admin&choice=members_list");
          die();
        }
      }

      }



    if(!empty($_POST['form_change_role_name'])){
      if(!empty($_POST['member_role_name'])){
        $array_members=$this->_db->select_members();
        foreach ($_POST['member_role_name'] as $i => $role_name) {
        $this->_db->change_role_name($array_members[$i]->html_login(), $role_name);
        }
      }

    }

    if(!empty($_POST['form_payed_fees'])){
      if(!empty($_POST['fees'])){
        foreach ($_POST['fees'] as $i => $login) {

          $this->_db->insert_member_fees($login,date('Y'));
        }
      }
    }


    if(!empty($_POST['form_new_annual_fee'])){
      if(!empty(trim($_POST['year'])) && !empty(trim($_POST['price']))){
        if($this->_db->annual_member_fees_exists($_POST['year'])){
          $errors[]='  Création impossible car la cotisation pour cette année-là existe deja  ';
        if(!preg_match(" /^[0-9]+$/ ",$_POST['year'])){
            $errors[]='Le champ année n\'est pas conforme.';
        }
        if(!preg_match(" /^[0-9]+$/ ",$_POST['price'])){
          $errors[]='Le champ prix n\'est pas conforme.';
        }
      }elseif (empty($errors)){
        $this->_db->insert_annual_member_fees($_POST['year'],$_POST['price']);
        $notification[]='  Cotisation crée avec succes  ';



      #  $to      = '';
      #  for ($i=0; $i <count($members) ; $i++) {
          #$to+=$members[$i]->html_email() . ', ';
      #  }


        $mail = new PHPMailer\PHPMailer\PHPMailer(true);// Utilisation du ‘namespace’ en PHP. Passing `true` enables exceptions
	      $mail->SMTPOptions = array(
	         'ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
	        );
	        try {
	           //Email Server settings
	            $mail->SMTPDebug = 0; // Enable verbose debug output
	            $mail->isSMTP();             // Set mailer to use SMTP
  	          $mail->Host ='smtp.gmail.com';  // Specify main SMTP servers
	            $mail->SMTPAuth = true;             // Enable SMTP authentication
	            $mail->Username = 'kolesgit1234@gmail.com'; // SMTP username
	            $mail->Password = 'mart1904@';                           // SMTP password
	            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	            $mail->Port = 587;                                    // TCP port to connect to
	            //Recipients
	            $mail->setFrom('kolesgit1234@gmail.com', 'Mailer'); // From
	            $mail->addAddress('kolesgit1234@gmail.com', 'koles');     // To recipient
	            $mail->addReplyTo('kolesgit1234@gmail.com', 'Sender'); // Adresse du client
	            //Content
              $mail->CharSet = CHARSET;
	            $mail->isHTML(true);                                  // Set email format to HTML
	            $mail->Subject = 'Payement cotisation pour l\'année ' . $_POST['year'] . '.';
	            $mail->Body    = 'Chers membres, une nouvelle année de cotisation a débuté. Veuillez vous acquitter de la somme de ' . $_POST['price']. ' euros sur le compte '.BANK_ACCOUNT.'.';
	            $mail->AltBody = 'Chers membres, une nouvelle année de cotisation a débuté. Veuillez vous acquitter de la somme de ' . $_POST['price']. ' euros sur le compte '.BANK_ACCOUNT.'.';
              $mail->send();
	            $notification[]=' Les mails ont été transmis avec succès. ';
	            } catch (Exception $e) {
	             $errors[]=' Les mails n\'ont pas été transmis.  '.'Mailer Error: '.$mail->ErrorInfo;
              }
            }
          }
        }




        if(!empty($_POST['form_create_event'])){
          if($this->mustProcessForm()){
            $this->processForm();
          }
          if(empty(trim($_POST['event_name']))){
            $errors[]=' Le champs nom doit être complété ';
          }
          if(empty(trim($_POST['event_address']))){
            $errors[]='  Le champs adresse doivt être complété ';
          }
          if(empty(trim($_POST['event_price']))){
            $errors[]='  Le champs prix doit être complété ';
          }
          if(empty(trim($_POST['event_start_date']))){
            $errors[]='  Le champs date de début doivt être complété ';
          }
          if(empty(trim($_POST['event_end_date']))){
            $errors[]='  Le champs date de fin doit être complété ';
          }
          if (!preg_match(" /^[0-9]+$/ ",$_POST['event_price'])) {
            $errors[]='  Le prix n\'est pas conforme <p>';
          }
          if (!preg_match(" /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/ ",$_POST['event_start_date'])) {
            $errors[]='  La date de début n\'est pas conforme <p>';
          }
          if (!preg_match(" /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/ ",$_POST['event_end_date'])) {
            $errors[]='  La date de fin n\'est pas conforme <p>';
          }
          if(!preg_match(" /^[0-9]+\.[0-9]+$/" ,$_POST['event_latitude']) || !preg_match(" /^[0-9]+\.[0-9]+$/ " ,$_POST['event_longitude'])){
            $errors[]='Les coordonnées GPS ne sont pas conformes.';
          }
          if(!empty($_POST['start_date']) && !empty($_POST['end_date']) && $_POST['start_date'] > $_POST['end_date']){
  					$errors[]='La date de début est postérieur à celle de fin!';
  				}
          elseif(empty($errors)) {
            #Using the Google's API to find the latitude and longitude
            /*
            $arrContextOptions=array(
              "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
              ),
            );
            $event_address=$_POST['event_address'];
            $url="https://maps.googleapis.com/maps/api/geocode/json?address=".$event_address."&key=AIzaSyBEoHw02cX_dgKX7JFti_Te-lDv1NWxgRw";
            $url=str_replace(" ","+",$url);
            $json=file_get_contents($url, false, stream_context_create($arrContextOptions));
            $parsee= json_decode($json,true);
            $value_lat= $parsee['results'][0]['geometry']['location']['lat'];
            $value_lng=$parsee['results'][0]['geometry']['location']['lng'];
            */


            $this->_db->insert_event($_POST['event_name'],$_POST['event_address'],$_POST['event_price'],$_POST['event_start_date'],$_POST['event_end_date'],$_POST['event_photo_url'],$this->getRawHtml(),$_POST['event_latitude'],$_POST['event_longitude']);
            $notification[]='  L\'événement a bien été ajouté.  ';
          }

        }

    $choice='';

    if(!empty($_GET['choice'])){
      $choice=$_GET['choice'];

    }
    #Arrays
    $duty='';
    $invalide_members=$this->_db->select_invalid_member();
    $members=$this->_db->select_members();
    $member_not_in_order=array();
    for ($i=0; $i < count($members); $i++) {
      if(!$this->_db->payed_member_fees($members[$i]->html_login(),date('Y'))){
          $member_not_in_order[]=$members[$i];
      }
    }

  require_once(VIEWS_PATH . 'admin.php');
  }

  // run() private methods
  private function mustProcessForm(){
    return isset($_POST['form_create_event']);
  }

  private function processForm(){
    $this->_raw_html = $_POST['event_description'];
  }



// view private methods
  private function getRawHtml(){
    return $this->_raw_html;
    }

  private function getEscapedHtml(){
    return htmlentities($this->_raw_html);
    }
}


?>
