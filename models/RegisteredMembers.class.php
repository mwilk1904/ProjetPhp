<?php class RegisteredMembers{

  private $_login;
  private $_event_id;
  private $_payed;

  public function __construct($login,$event_id,$payed){
    $this->_login=$login;
    $this->_event_id=$event_id;
    $this->_payed=$payed;
  }

  public function login(){
    return $this->_login;
  }

  public function event_id(){
    return $this->_event_id;
  }

  public function payed(){
    return $this->_payed;
  }

  public function html_login(){
    return htmlspecialchars($this->_login);
  }

  public function html_event_id(){
    return htmlspecialchars($this->_event_id);
  }

  public function html_payed(){
    return htmlspecialchars($this->_payed);
  }


} ?>
