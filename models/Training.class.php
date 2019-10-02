<?php
class Training{
	private $_training_id;
	private $_descriptive;

	public function __construct($training_id,$descriptive){
		$this->_training_id=$training_id;
		$this->_descriptive =$descriptive;
	}

	public function training_id(){
		return $this->_training_id;
	}

	public function descriptive(){
		return $this->_descriptive;
	}

    public function html_training_id(){
		return htmlspecialchars($this->_training_id);
	}

	public function html_descriptive(){
		return htmlspecialchars($this->_descriptive);
	}

}
?>
