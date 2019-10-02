<?php
class EventController{
	private $_db;
	private $_raw_html;

	public function __construct($db) {
		$this->_db = $db;
		$this->_raw_html='';
	}

	public function run(){
		if (empty($_SESSION['authentificate'])) {
			header("Location: index.php?action=home");
			die();
		}

		$notification=array();
		$errors=array();
		$info_event = array();
		$button_interested = '';
		$button_subscribe = '';
		if(!empty($_GET['event_id']) && $this->_db->verify_event_id($_GET['event_id'])){
			if(!empty($_POST['interested'])){
				if($_POST['interested']=='Je suis interessé'){
					$this->_db->insert_interested($_SESSION['login'],$_GET['event_id']);
				}
				else {
					$this->_db->delete_interested($_SESSION['login'],$_GET['event_id']);
				}
			}

			elseif (!empty($_POST['subscribe'])) {
				if($_POST['subscribe']=="Inscrire"){
					$this->_db->insert_subscribe($_SESSION['login'],$_GET['event_id']);
				}
				else {
					$this->_db->delete_subscribe($_SESSION['login'],$_GET['event_id']);
				}
			}

			elseif (!empty($_POST['payed'])) {
				if($_POST['payed']=="Payer"){
					$this->_db->update_payed($_SESSION['login'],$_GET['event_id']);
				}
			}

			if(!empty($_POST['form_modify_event'])){
				if($this->mustProcessForm()){
					$this->processForm();
				}
				if(empty(trim($_POST['name']))){
					$errors[]='  Le champs nom doit être complété ';
				}
				if(empty(trim($_POST['address']))){
					$errors[]='  Le champs adresse doit être complété ';
				}
				if(empty(trim($_POST['price']))){
					$errors[]='  Le champs prix doit être complété ';
				}
				if(empty(trim($_POST['start_date']))){
					$errors[]='  Le champs date de début doivt être complété ';
				}
				if(empty(trim($_POST['end_date']))){
					$errors[]='  Le champs date de fin doit être complété ';
				}
				if (!preg_match(" /^[0-9]+$/ ",$_POST['price'])) {
					$errors[]='  Le prix n\'est pas conforme ';
				}
				if (!preg_match(" /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/ ",$_POST['start_date'])) {
					$errors[]='  La date de début n\'est pas conforme';
				}
				if (!preg_match(" /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/ ",$_POST['end_date'])) {
					$errors[]='  La date de fin n\'est pas conforme ';
				}
				if(!preg_match(" /^[0-9]+\.[0-9]+$/" ,$_POST['latitude']) || !preg_match(" /^[0-9]+\.[0-9]+$/ " ,$_POST['longitude'])){
					$errors[]='Les coordonnées GPS ne sont pas conformes.';
				}
				if($_POST['start_date'] > $_POST['end_date']){
					$errors[]='La date de début est postérieur à celle de fin!';
				}
				elseif(empty($errors)) {

					#Using the Google's API to find the latitude and longitude
					/*$arrContextOptions=array(
						"ssl"=>array(
							"verify_peer"=>false,
							"verify_peer_name"=>false,
						),
					);
					$event_address=$_POST['address'];
					$url="https://maps.googleapis.com/maps/api/geocode/json?address=".$event_address."&key=AIzaSyBEoHw02cX_dgKX7JFti_Te-lDv1NWxgRw";
					$url=str_replace(" ","+",$url);
					$json=file_get_contents($url, false, stream_context_create($arrContextOptions));
					$parsee= json_decode($json,true);
					if(!empty($parsee['results'])){
						$value_lat= $parsee['results'][0]['geometry']['location']['lat'];
						$value_lng=$parsee['results'][0]['geometry']['location']['lng'];
					*/
						if(!empty($_POST['description'])){
							$this->_db->update_event($_GET['event_id'],$_POST['name'],$_POST['address'],$_POST['price'],$_POST['start_date'],$_POST['end_date'],$_POST['url'],$this->getRawHtml(),$_POST['latitude'],$_POST['longitude']);
						}else{
							$this->_db->update_event($_GET['event_id'],$_POST['name'],$_POST['address'],$_POST['price'],$_POST['start_date'],$_POST['end_date'],$_POST['url'],$info_event->description(),$_POST['latitude'],$_POST['longitude']);
						}
						$notification[]=' L\'événement a bien été modifié.  ';

				}

			}
			if(!empty($_POST['form_payed_registration'])){
				if(!empty($_POST['payed'])){
					foreach ($_POST['payed'] as $i => $login) {
						$this->_db->update_payed_registered($login,$_GET['event_id'],1);
					}
				}
			}

			if(!empty($_POST['form_delete_event'])){
				$this->_db->delete_all_interested($_GET['event_id']);
				$this->_db->delete_all_registered($_GET['event_id']);
				$this->_db->delete_event($_GET['event_id']);
				$notification[]=' L\'événement a bien été supprimé. ';
				header("Location: index.php?action=event");
				die();
			}
			$choice='';

			if(!empty($_GET['choice'])){
				$choice=$_GET['choice'];

			}
			#Arrays
			$interested_members=array();
			$array_interested=$this->_db->select_interested($_GET['event_id']);
			for ($i=0; $i < count($array_interested); $i++) {
				$interested_members[]=$this->_db->select_member($array_interested[$i]->html_login());
			}

			$registered_members=array();
			$array_registered=$this->_db->select_registered($_GET['event_id']);
			for ($i=0; $i < count($array_registered); $i++) {
				$registered_members[]=$this->_db->select_member($array_registered[$i]->html_login());
			}

			$registered_not_payed_members=array();
			for ($i=0; $i < count($registered_members); $i++) {
				if(!$this->_db->payed_registered($registered_members[$i]->html_login(),$_GET['event_id']))
					$registered_not_payed_members[]=$registered_members[$i];
			}


			$info_event = $this->_db->select_event($_GET['event_id']);
			$button_interested = $this->_db->select_button_interested($_SESSION['login'],$_GET['event_id']);
			$button_subscribe = $this->_db->select_button_subscribe($_SESSION['login'],$_GET['event_id']);

				}

			$array_past_events = $this->_db->select_past_events();
			$array_futur_events = $this->_db->select_futur_events();


		if($_SESSION['duty'] == 'm')
			require_once(VIEWS_PATH . 'event_member.php');
		else
			require_once(VIEWS_PATH . 'event_responsible.php');




		}
		// run() private methods
	  private function mustProcessForm(){
	    return isset($_POST['form_modify_event']);
	  }

	  private function processForm(){
	    $this->_raw_html = $_POST['description'];
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
