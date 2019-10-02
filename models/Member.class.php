<?php
class Member{
	private $_login;
	private $_password;
	private $_name;
	private $_first_name;
	private $_phone;
	private $_email;
	private $_bank_account;
	private $_address;
	private $_photo;
	private $_duty;
	private $_validate;
	private $_role_name;

	public function __construct($login,$password,$name,$first_name,$phone,$email,$bank_account,$address,$photo,$duty,$validate,$role_name){
		$this->_login=$login;
		$this->_password =$password;
		$this->_name=$name;
		$this->_first_name = $first_name;
		$this->_phone = $phone;
		$this->_email = $email;
		$this->_bank_account = $bank_account;
		$this->_address = $address;
		$this->_photo = $photo;
		$this->_duty = $duty;
		$this->_validate = $validate;
		$this->_role_name = $role_name;

	}

	public function login(){
		return $this->_login;
	}

	public function password(){
		return $this->_password;
	}

	public function name(){
		return $this->_name;
	}

	public function first_name(){
		return $this->_first_name;
	}

	public function phone(){
		return $this->_phone;
	}

	public function email(){
		return $this->_email;
	}

	public function bank_account(){
		return $this->_bank_account;
	}

	public function address(){
		return $this->_address;
	}

	public function photo(){
		return $this->_photo;
	}

	public function duty(){
		return $this->_duty;
	}

	public function validate(){
		return $this->_validate;
	}

	public function role_name(){
		return $this->_role_name;
	}



	public function html_name(){
		return htmlspecialchars($this->_name);
	}

	public function html_first_name(){
		return htmlspecialchars($this->_first_name);
	}

	public function html_login(){
		return htmlspecialchars($this->_login);
	}

	public function html_password(){
		return htmlspecialchars($this->_password);
	}

	public function html_email(){
		return htmlspecialchars($this->_email);
	}

	public function html_photo(){
		return htmlspecialchars($this->_photo);
	}

	public function html_address(){
		return htmlspecialchars($this->_address);
	}

	public function html_phone(){
		return htmlspecialchars($this->_phone);
	}

	public function html_bank_account(){
		return htmlspecialchars($this->_bank_account);
	}

	public function html_role_name(){
		return htmlspecialchars($this->_role_name);
	}

	public function html_duty(){
		return htmlspecialchars($this->_duty);
	}



}
?>
