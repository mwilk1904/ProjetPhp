<?php class MemberFees{
  private $_login;
  private $_year;

  public function __construct($login,$year){
    $this->_login=$login;
    $this->_year=$year;
  }

  public function login(){
    return $this->_login;
  }

  public function year(){
    return $this->_year;
  }

  public function html_login(){
    return htmlspecialchars($this->_login);
  }

  public function html_year(){
    return htmlspecialchars($this->_year);
  }




} ?>
