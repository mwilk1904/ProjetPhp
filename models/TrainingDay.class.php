<?php
class TrainingDay{
	private $_training_id;
	private $_date;
	private $_activity;

	public function __construct($training_id,$date,$activity){
		$this->_training_id=$training_id;
		$this->_date =$date;
		$this->_activity =$activity;
	}

	public function training_id(){
		return $this->_training_id;
	}

	public function date(){
		return $this->_date;
	}


	public function activity(){
		return $this->_activity;
	}

    public function html_training_id(){
		return htmlspecialchars($this->_training_id);
	}

	public function html_date(){
		return htmlspecialchars($this->_date);
	}

	public function html_activity(){
		return htmlspecialchars($this->_activity);
	}

}
?>
