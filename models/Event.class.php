<?php
class Event{
  private $_event_id;
  private $_name;
  private $_address;
  private $_price;
  private $_start_date;
  private $_end_date;
  private $_url_photo;
  private $_descriptive;
  private $_latitude;
  private $_longitude;

  public function __construct($event_id,$name,$address,$price,$start_date,$end_date,$url_photo,$descriptive,$latitude,$longitude){
    $this->_event_id=$event_id;
    $this->_name=$name;
    $this->_address=$address;
    $this->_price=$price;
    $this->_start_date=$start_date;
    $this->_end_date=$end_date;
    $this->_url_photo=$url_photo;
    $this->_descriptive=$descriptive;
    $this->_latitude=$latitude;
    $this->_longitude=$longitude;
  }

  public function event_id(){
    return $this->_event_id;
  }

  public function name(){
    return $this->_name;
  }

  public function address(){
    return $this->_address;
  }

  public function price(){
    return $this->_price;
  }

  public function start_date(){
    return $this->_start_date;
  }

  public function end_date(){
    return $this->_end_date;
  }

    public function url_photo(){
    return $this->_url_photo;
  }

  public function descriptive(){
    return $this->_descriptive;
  }

  public function latitude(){
    return $this->_latitude;
  }

  public function longitude(){
    return $this->_longitude;
  }

  public function html_event_id(){
      return htmlspecialchars($this->_event_id);
  }

  public function html_name(){
      return htmlspecialchars($this->_name);
  }

  public function html_descriptive(){
      return htmlspecialchars($this->_descriptive);
  }

  public function html_address(){
      return htmlspecialchars($this->_address);
  }

  public function html_price(){
      return htmlspecialchars($this->_price);
  }

  public function html_start_date(){
      $temp_date = str_replace("-","/",$this->_start_date);
      $temp_date = date('d/m/Y', strtotime($temp_date));
      return htmlspecialchars($temp_date);
  }

  public function html_end_date(){
      $temp_date = str_replace("-","/",$this->_end_date);
      $temp_date = date('d/m/Y', strtotime($temp_date));
      return htmlspecialchars($temp_date);
  }

  public function html_url(){
      return htmlspecialchars($this->_url_photo);
  }

  public function html_latitude(){
      return htmlspecialchars($this->_latitude);
  }

  public function html_longitude(){
      return htmlspecialchars($this->_longitude);
  }









}
 ?>
